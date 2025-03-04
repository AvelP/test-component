BX.Vue3.createApp({
    data() {
        return {
            deals: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        BX.ajax.runAction('local:dealapi.getDeals')
            .then(response => {
                console.log("Ответ API:", response);
                if (response.data && response.data.deals) {
                    this.deals = response.data.deals;
                } else {
                    throw new Error("Пустой ответ от API");
                }
                this.loading = false;
            })
            .catch(err => {
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
}).mount("#app");
