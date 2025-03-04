BX.Vue3.createApp({
    data() {
        return {
            deals: [],
            loading: true,
            error: null,
            currentPage: 1,  // Текущая страница
            itemsPerPage: 5, // Сделок на страницу
            totalPages: 1,   // Всего страниц
            sortKey: "TITLE", // Поле для сортировки
            sortOrder: "asc" // Направление сортировки
        };
    },
    computed: {
        paginatedDeals() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.deals.slice(start, start + this.itemsPerPage);
        }
    },
    mounted() {
        this.fetchDeals();
    },
    methods: {
        fetchDeals() {
            this.loading = true;
            BX.ajax({
                url: "/local/components/local/deal.list/ajax.php",
                method: "GET",
                dataType: "json",
                data: {
                    action: "getDeals",
                    sortKey: this.sortKey,
                    sortOrder: this.sortOrder,
                    currentPage: this.currentPage,
                    itemsPerPage: this.itemsPerPage
                },
                onsuccess: (response) => {
                    if (response.status === "success") {
                        this.deals = response.data.deals;
                        this.totalPages = Math.ceil(response.data.totalCount / this.itemsPerPage);
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
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.fetchDeals(); // Загружаем новые данные
            }
        },
        sortDeals() {
            this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
            this.fetchDeals();
        }
    },
    template: `
        <div>
            <h2>Список сделок</h2>
            <div v-if="loading">Загрузка...</div>
            <div v-if="error">{{ error }}</div>
            <table v-if="!loading && !error">
                <tr>
                    <th @click="sortDeals">Название {{ sortOrder === 'asc' ? '▲' : '▼' }}</th>
                </tr>
                <tr v-for="deal in paginatedDeals" :key="deal.ID">
                    <td>{{ deal.TITLE }}</td>
                </tr>
            </table>
            <div v-if="totalPages > 1">
                <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Назад</button>
                <span>Страница {{ currentPage }} из {{ totalPages }}</span>
                <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Вперед</button>
            </div>
        </div>
    `
}).mount("#app");
