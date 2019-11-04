<template>
    <div class="components-list">
        <div class="components-col-body">
            <div class="components-header">
                <h1>DS Pro</h1>
                <div class="components-actions-bar">
                    <font-awesome-icon icon="skull-crossbones" @click="filter" class="clickable" :class="{ active: filtered }" />
                    <font-awesome-icon icon="plus" @click="addComponent" class="clickable" />
                </div>
                <div class="components-search">
                    <font-awesome-icon icon="search" class="search-icon" />
                    <input type="search" placeholder="Search Components" class="form-control" v-model="searchTerm">
                </div>
            </div>
            <div class="components">
                <div class="component" v-for="component in displayedComponents" :key="component.id" :class="{ selected: selectedComponent === component }" @click="selectComponent(component)">
                    <span class="component-label">{{ component.title }}</span>
                    <font-awesome-icon icon="skull-crossbones" v-if="component.needs_changes" class="changes-icon" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        components: Array,
        selectedComponent: Object,
    },
    data: () => ({
        filtered: false,
        searchTerm: null,
    }),
    computed: {
        displayedComponents() {
            let filteredComps = this.components;
            if (this.filtered) {
                filteredComps = filteredComps.filter(c => c.needs_changes);
            }
            if (this.searchTerm) {
                filteredComps = filteredComps.filter(c => c.title.toLowerCase().includes(this.searchTerm.toLowerCase()));
            }
            return filteredComps.sort((a, b) => a.title.localeCompare(b.title));
        }
    },
    methods: {
        selectComponent(component) {
            this.$emit('selectComponent', component);
        },
        addComponent() {
            if (this.components.find(c => c.id === -1)) {
                window.alert('Please save new component before creating another new component.');
            } else {
                this.$emit('addComponent');
            }
        },
        filter() {
            this.filtered = !this.filtered;
        }
    }
}
</script>

<style lang="scss">
    .components-list {
        height: 100%;
    }

    .components {
        flex: 1;
        overflow-y: scroll;
    }

    .components-col-body {
        border-right: solid 1px rgb(206, 212, 218);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .components-header {
        padding: 20px;
        padding-bottom: 15px;

        .components-search {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 8px;
            top: 11px;
        }

        input[type="search"] {
            padding-left: 30px;
        }
    }

    .components-actions-bar {
        height: 40px;
        padding: 10px 5px;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;

        svg {
            margin-left: 10px;

            &.active {
                color: #3490dc;
            }
        }
    }

    .component {
        display: flex;
        align-items: center;
        height: 30px;
        padding: 0px 28px;
        cursor: pointer;

        .component-label {
            font-size: 16px;
            padding-top: 2px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .changes-icon {
            color: #333;
            margin-left: auto;
        }

        &.selected {
            background: darken(#f8fafc, 30);
        }
    }

    .clickable {
        cursor: pointer;
    }
</style>