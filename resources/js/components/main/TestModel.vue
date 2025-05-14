<template>
    <main class="col-lg-8 offset-lg-2 mt-4">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <router-link :to="`/app/models/${model_id}`"
                             class="navbar-brand">{{ getSelectedModel.name }} Model
                </router-link>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid mt-5 test-modal">
            <h1 class="mb-4">{{ getSelectedModel.name }} Test</h1>

            <div class="card">
                <div class="card-body" style="min-height:400px; max-height: 400px; overflow-y: scroll;">
                    <div v-for="(message, index) in messages" :key="index" class="mb-3">
                        <p><strong>{{ message.sender }}</strong>: {{ message.text }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <textarea v-model="newMessage" @keyup.enter="sendMessage" class="form-control"
                          placeholder="Type your message..."></textarea>
            </div>
        </div>
    </main>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'TestModel',
    data() {
        return {
            socket: null,
            model_id: false,
            messages: [],
            prompt: '',
            response: '',
            newMessage: ''
        }
    },
    created() {
        this.model_id = this.$route.params.uuid;
        this.initWebSocket();
        this.fetchModal()
        this.fetchSupportData()
    },
    computed: {
        ...mapGetters('user', ['getUser']),
        ...mapGetters('model', ['getSelectedModel', 'getTestModel']),
        ...mapGetters('supportdata', ['getSupportData']),
    },
    methods: {
        ...mapActions('model', ['httpGetModelDetail', 'httpTestModel']),
        ...mapActions('supportdata', ['httpGetSupportData']),

        initWebSocket() {
            const ws_url = `ws://127.0.0.1:8090/ws/chat/${this.model_id}/`;
            this.socket = new WebSocket(ws_url);
            this.socket.onopen = () => {
                console.log("WebSocket connected");
            };
            this.socket.onmessage = (event) => {
                const parsed_data = JSON.parse(event.data);
                const reply = parsed_data.reply?.trim();
                if(reply){
                    this.messages.push({
                        sender: "Bot",
                        text: reply
                    });
                }
            };
            this.socket.onerror = (error) => {
                console.error("WebSocket error:", error);
            };
            this.socket.onclose = () => {
                console.warn("WebSocket closed. Attempting to reconnect...");
                setTimeout(this.initWebSocket, 2000);
            };
        },

        async sendMessage() {
            if (this.newMessage.trim() === '') return;

            const msg = {
                message: this.newMessage
            };

            this.messages.push({sender: 'You', text: this.newMessage});
            console.log(JSON.stringify(msg))
            this.socket.send(JSON.stringify(msg));
            console.log(this.newMessage)
            console.log(this.messages)
            this.newMessage = '';
        },

        saveResponse() {
            console.log(this.messages)
        },

        async fetchSupportData() {
            try {
                await this.httpGetSupportData({uuid: this.model_id, props: ''})
            } catch (error) {

            }
        },

        async fetchModal() {
            try {
                await this.httpGetModelDetail(this.model_id)
            } catch (error) {

            }
        },
    },
    watch: {
        getSelectedModel() {
            return this.getSelectedModel
        }
    },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.card {
    border: var(--bs-border-width) solid var(--bs-border-color);
}

.test-modal {
    .alert {
        .alert-message-action {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            padding: 5px 10px;

            .message {
                font-size: 13px;
                margin-bottom: 0;
            }

            .action {
                width: 100%;

                button {
                    float: right;
                }
            }
        }
    }
}

.model-info {
    border-radius: 10px;
}
</style>
