BX.Vue3.component('local.deal.list', {
    data() {
        return {
            deals: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        BX.ajax.runAction('local.deal.list.getDeals')
            .then(response => {
                console.log("Ответ API:", response);
                if (response.status === "success") {
                    this.deals = response.data.deals;  // Исправлено на response.data.deals
                    this.loading = false;
                } else {
                    throw new Error("Ошибка данных API");
                }
            })
            .catch((err) => {
                console.error("Ошибка запроса:", err);
                this.error = "Ошибка загрузки данных!";
                this.loading = false;
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
});
