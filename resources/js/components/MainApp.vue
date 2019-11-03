<template>
    <div class="app-wrapper row">
        <div class="components-list-wrapper col-3">
            <components-list ref="compList" :components="components" :selected-component="selectedComponent" @selectComponent="updateSelectedComponent" @addComponent="addComponent" />
        </div>
        <div class="main-body col-9">
            <component-form :component="selectedComponent" @componentUpdated="updateComponent" />
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
            this.$refs.compList.$forceUpdate();
        },
        updateComponent(newComponent) {
            let oldCompIdx = this.components.findIndex(c => c.id === newComponent.id);

            if (oldCompIdx === -1) {
                oldCompIdx = this.components.findIndex(c => c.id === -1);
            }
            Vue.set(this.components, oldCompIdx, newComponent);
        }
    }
}
</script>

<style lang="scss">
    .app-wrapper, .components-list-wrapper {
        height: 100%;
    }

    .main-body {
        margin: auto;
        margin-top: 60px;
    }
</style>