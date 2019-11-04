<template>
    <div class="app-wrapper row">
        <div class="components-list-wrapper col-3">
            <components-list ref="compList" :components="components" :selected-component="selectedComponent" @selectComponent="updateSelectedComponent" @addComponent="addComponent" />
        </div>
        <div class="main-body col-9">
            <component-form v-if="selectedComponent" :component="selectedComponent" @componentUpdated="updateComponent" @componentDeleted="removeComponent" />
            <div class="banner" v-else>
                <h2>Select a component or add a new component to get started.</h2>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        components: Array,
    },
    data: () => ({
        selectedComponent: null,
    }),
    mounted() {
        this.selectedComponent = this.components[0];
    },
    methods: {
        updateSelectedComponent(component) {
            this.selectedComponent = component;
        },
        addComponent() {
            const newComp = {
                id: -1,
                title: 'New Component',
                link: null,
                description: null,
                comments: null,
                needs_changes: false,
            };
            Vue.set(this.components, this.components.length, newComp);
            this.selectedComponent = this.components[this.components.length - 1];
            this.$refs.compList.$forceUpdate();
        },
        updateComponent(newComponent) {
            let oldCompIdx = this.components.findIndex(c => c.id === newComponent.id);

            if (oldCompIdx === -1) {
                oldCompIdx = this.components.findIndex(c => c.id === -1);
            }
            Vue.set(this.components, oldCompIdx, newComponent);
            this.$refs.compList.$forceUpdate();
        },
        removeComponent(component) {
            let compIdx = this.components.findIndex(c => c.id === component.id);
            this.components.splice(compIdx, 1);
            this.$refs.compList.$forceUpdate();
            if (this.components.length > 0) {
                this.selectedComponent = this.components[0];
            } else {
                this.selectedComponent = null;
            }
        }
    }
}
</script>

<style lang="scss">
    .app-wrapper, .components-list-wrapper {
        height: 100%;
    }

    .main-body {
        height: 100%;
        margin: auto;
        margin-top: 60px;
    }

    .banner {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        h2 {
            text-align: center;
        }
    }
</style>