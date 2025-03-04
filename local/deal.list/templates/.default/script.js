BX.Vue3.createApp({
    data() {
        return {
            deals: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        BX.ajax({
            url: '/local/components/local/deal.list/ajax.php',
            data: { action: 'getDeals' },
            method: 'GET',
            dataType: 'json',
            onsuccess: function(response) {
                console.log(response);
                this.deals = response.data;
            },
            onfailure: function(error) {
                console.error("Ошибка загрузки данных!", error);
            }
        });
    },
    template: `
        <div>
            <h2>Список сделок</h2>
            <div v-if="loading">Загрузка...</div>
            <div v-if="error">{{ error }}</div>
            <table v-if="!loading && !error">
                <tr>
                    <th @click="sortDeals">Название ▲</th>
                </tr>
                <tr v-for="deal in deals" :key="deal.ID">
                    <td>{{ deal.TITLE }}</td>
                </tr>
            </table>
        </div>
    `,
    methods: {
        sortDeals() {
            this.deals.sort((a, b) => a.TITLE.localeCompare(b.TITLE));
        }
    }
}).mount("#app");
