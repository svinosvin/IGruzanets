export default class Query{

    page: number;
    perPage: number;
    filters: Map<String, String>;

    constructor(page = 1, perPage = 3) {
        this.page = page;
        this.perPage = perPage;
        this.filters = new Map<String, String>();
    }

    public addFilter(filter, value: String) {
        this.filters.set(`filter[${filter}]`,`${value}`);
    }
    public removeFilter(filter) {
        this.filters.delete(filter)
        console.log(filter);
        console.log(Object.fromEntries(this.filters));
    }

    public getParams() {
        return {
            ...Object.fromEntries(this.filters)
        }
    }
    public deleteParams(){
        this.filters = new Map<String, String>();

    }
}
