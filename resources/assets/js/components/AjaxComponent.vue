<template>
    <div class="container">
        <div class="row">
            <!--<button @click="update" class="btn btn-default" v-if="!is_refresh">Refresh - {{ id }}</button>-->
            <!--<span class="badge badge-primary mb-1" v-if="is_refresh">Обновление...</span>-->
            <!--<button @click="update" class="btn btn-default">Refresh - {{ id }}</button>-->
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="article in articles">
                    <td>{{ article.title }}</td>
                    <td>{{ article.description_shot }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
    export default {
        data: function () {
            return {
                articles: [],
                is_refresh: false,
                id: 0
            }
        },
        mounted() {
            this.update();
        },
        methods: {
            update: function () {
                this.is_refresh = true;
                axios.get('/getArticles').then((responce) => {
                    this.articles = responce.data.data;
                    this.is_refresh = false;
                    this.id++;
                });
            }
        }
    }
</script>
