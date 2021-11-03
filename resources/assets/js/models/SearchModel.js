import SORTING_DIRECTION from "@models/CONSTANTS";

class SearchModel {

    list = [];
    pageSize = 15;
    currentPage = 0;
    simpleFilters = {};
    collectionFilters = [];
    tags = [];
    sortingDirection = SORTING_DIRECTION.ASCENDING;
    sortingColumn = "";

    constructor(
        list,
        pageSize,
        currentPage,
        simpleFilters,
        collectionFilters,
        tags,
        sortingColumn,
        sortingDirection = SORTING_DIRECTION.ASCENDING
    ) {
        this.list = list;
        this.pageSize = pageSize;
        this.currentPage = currentPage;
        this.simpleFilters = simpleFilters;
        this.collectionFilters = collectionFilters;
        this.tags = tags;
        this.sortingColumn = sortingColumn;
        this.sortingDirection = sortingDirection;
    }
}

export default SearchModel;
