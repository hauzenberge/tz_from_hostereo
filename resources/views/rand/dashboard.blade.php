<x-app-layout>
    <div id="app">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a class="btn btn-light" href="{{ $url.'/render' }}">{{ __('Rerender Link') }}</a>
                <a class="btn btn-danger" href="{{ $url.'/disable' }}">{{ __('Dsiable Link') }}</a>
            </h2>
        </x-slot>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card">
                    <div class="card-header">
                        <button @click="lucky()" class="btn btn-success">Мені пощастить</button>
                        <button @click="history()" class="btn btn-warning">Історія</button>
                    </div>
                    <div class="card-body">
                        <div v-if="histories">
                            <div v-for="history in histories">
                                <strong>@{{history.id}} )</strong>  @{{history.result}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: function() {
                return {
                    url: <?php echo json_encode($url); ?>,
                    link: <?php echo json_encode($link); ?>,
                    messege: '',
                    histories: ''
                };
            },
            methods: {
                lucky: function() {
                    axios.post(this.url + '/lucky', {}).then(function(response) {
                        alert(response.data.massege);
                        this.messege = response.data.massege;
                    });
                },
                history: function() {
                    axios.post(this.url + '/history', {})
                        .then(response => (this.histories = response.data));
                },
            },
            computed: {}
        });
    </script>
</x-app-layout>