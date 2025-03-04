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
            url: "/local/components/local/deal.list/ajax.php?action=getDeals",
            method: "GET",
            dataType: "json",
            onsuccess: (response) => { // Используем стрелочную функцию
                console.log(response);
                if (response.status === "success") {
                    this.deals = response.data;
                } else {
                    this.error = "Ошибка загрузки данных!";
                }
                this.loading = false;
            },
            onfailure: (error) => {
                console.error("Ошибка загрузки данных!", error);
                this.error = "Ошибка загрузки данных!";
                this.loading = false;
            },
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
