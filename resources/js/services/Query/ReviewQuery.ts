import Query from "./Query";

export default class ReviewQuery extends Query{

    public readonly IS_ACTIVE = "is_active"


    public getParams() {
        return {
            page: this.page,
            per_page: this.perPage,
            ...Object.fromEntries(this.filters)
        }
    }
}

