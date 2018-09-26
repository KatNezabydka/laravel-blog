<template>
    <div class="container">
        <div class="row justify-content-center">
           <h1>I am new component</h1>
        </div>
        <div class="row justify-content-center">
            <h2>And I'm incredible angry</h2>
        </div>
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
</template>


<script>
    export default {
        props: [
            'articles'
        ],
        mounted() {
            this.update();
        },
        methods: {
            update: function () {

            }
        }
    }
</script>
