BX.Vue3.createApp({
    data() {
        return {
            deals: [],
            loading: false,
            error: null,
            lastId: null, // ID последней загруженной сделки
            hasMore: true, // Есть ли еще сделки
            itemsPerPage: 5, // Количество сделок на страницу
            sortOrder: "ASC" // Сортировка
        };
    },
    mounted() {
        this.fetchDeals();
    },
    methods: {
        fetchDeals() {
            if (!this.hasMore) return; // Если больше нечего загружать, выходим

            this.loading = true;
            BX.ajax({
                url: "/local/components/local/deal.list/ajax.php",
                method: "GET",
                dataType: "json",
                data: {
                    action: "getDeals",
                    lastId: this.lastId, // Передаем ID последней сделки
                    itemsPerPage: this.itemsPerPage,
                    sortOrder: this.sortOrder
                },
                onsuccess: (response) => {
                    if (response.status === "success") {
                        if (response.data.deals.length > 0) {
                            this.deals = [...this.deals, ...response.data.deals]; // Добавляем новые сделки
                            this.lastId = response.data.deals[response.data.deals.length - 1].ID; // Обновляем lastId
                        } else {
                            this.hasMore = false; // Больше сделок нет
                        }
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
        }
    },
    template: `
        <div>
            <h2>Список сделок</h2>
            <div v-if="error">{{ error }}</div>
            <table v-if="deals.length">
                <tr>
                    <th>Название</th>
                </tr>
                <tr v-for="deal in deals" :key="deal.ID">
                    <td>{{ deal.TITLE }}</td>
                </tr>
            </table>
            <button v-if="hasMore" @click="fetchDeals" :disabled="loading">
                {{ loading ? "Загрузка..." : "Загрузить еще" }}
            </button>
        </div>
    `
}).mount("#app");




