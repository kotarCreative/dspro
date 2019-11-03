<template>
    <div class="component-form">
        <div class="row">
            <div class="figma-viewer col-7">
                <div class="figma-link-generator">
                    <div class="form-group">
                        <label for="link">Figma Link</label>
                        <div class="form-inline">
                            <input type="text" id="link" class="form-control flex-grow-1" v-model="editedComponent.link" @onBlur="set" />
                            <button class="btn btn-primary ml-1 changes-btn" :class="{ 'btn-danger': editedComponent.needs_changes }" @click="toggleNeedsChanges">
                                {{ editedComponent.needs_changes ? 'Changes Needed' : 'Up-to-Date' }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="figma-view-port">
                    <iframe
                        class="figma-frame"
                        ref="frame"
                        height="450"
                        width="100%"
                        :src="url"
                        allowfullscreen
                    />
                    <div class="errors">
                        <div class="alert alert-danger" v-for="error in errors" :key="error">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control" v-model="editedComponent.title" />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" id="description" class="form-control noresize" rows="10" v-model="editedComponent.description"></textarea>
                </div>
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea type="text" id="comments" class="form-control noresize" rows="5" v-model="editedComponent.comments"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100" @click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const urlValidator = /https:\/\/([\w\.-]+\.)?figma.com\/(file|proto)\/([0-9a-zA-Z]{22,128})(?:\/.*)?$/;
const urlPrefix = 'https://www.figma.com/embed?embed_host=astra&url=';
export default {
    props: {
        component: {
            title: String,
            description: String,
            comments: String,
            link: String,
            needs_changes: Boolean,
        }
    },
    data: () => ({
        editedComponent: {
            title: null,
            description: null,
            comments: null,
            link: null,
            needs_changes: false,
        },
        errors: [],
    }),
    computed: {
        url() {
            return urlPrefix + this.editedComponent.link;
        }
    },
    methods: {
        save() {
            this.errors.splice(0, this.errors.length);
            if (!this.editedComponent.title || !this.editedComponent.link) {
                this.errors.push('The component title and link are required.');
                return;
            }

            if (!urlValidator.test(this.editedComponent.link)) {
                this.errors.push('Not a valid figma link.');
                return;
            }

            if (this.editedComponent.id > 0) {
                axios.patch(`/components/${this.editedComponent.id}`, { ...this.editedComponent }).then(response => {
                    this.$emit('componentUpdated', response.data.component);
                });
            } else {
                axios.post('/components', { ...this.editedComponent }).then(response => {
                    this.$emit('componentUpdated', response.data.component);
                });
            }
        },
        set() {
            this.$refs.frame.contentWindow.location.reload();
        },
        toggleNeedsChanges() {
            this.editedComponent.needs_changes = !this.editedComponent.needs_changes;
        }
    },
    watch: {
        component(value) {
            this.editedComponent = _.clone(value);
            this.set();
        }
    }
}
</script>

<style lang="scss">
    .component-form {
        padding: 20px;
    }

    .changes-btn {
        width: 137px;
    }

    .figma-frame {
        border: solid 1px rgb(206, 212, 218);
        border-radius: 5px;
    }

    .noresize {
        resize: none;
    }
</style>