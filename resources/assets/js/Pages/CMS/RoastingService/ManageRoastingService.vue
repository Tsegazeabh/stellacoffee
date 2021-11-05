<template>
    <div class="flex flex-wrap w-full">
        <div class="breadcrump">
            <ul>
                <li>
                    <inertia-link :href="route('home')">{{ _trans('menu.Home') }}</inertia-link>
                </li>
                <li>
                    <inertia-link :href="route('dashboard')">{{ _trans('menu.CMS') }}</inertia-link>
                </li>
                <li>{{ _trans('label.shared.Roasting Service') }}</li>
            </ul>
        </div>
        <div class="flex flex-wrap w-full justify-end">
            <inertia-link type="button" :href="route('roasting-service-creation-page')"
                          class="border text-gray-500 px-4 py-2 uppercase text-sm">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ _trans('label.shared.Create Roasting Service') }}
            </inertia-link>
        </div>
        <form class="flex flex-wrap w-full py-8">
            <div class="form-group sm:w-full md:w-1/2 md:pr-6">
                <input type="text" v-model="searchModel.simpleFilters['search_keyword']" class="form-control w-full"
                       :placeholder="_trans('label.shared.Search Keyword')"/>
            </div>
            <div class="form-group sm:my-4 md:my-0 sm:w-full md:w-1/2 flex flex-wrap justify-end items-center">
                <select type="text" v-model="searchModel.simpleFilters['content_status']"
                        class="form-control flex-grow sm:w-full md:w-max sm:mb-4 md:mb-0">
                    <option value="1">{{ _trans('label.Status.Unpublished') }}</option>
                    <option value="2">{{ _trans('label.Status.Published') }}</option>
                    <option value="3">{{ _trans('label.Status.Archived') }}</option>
                    <option value="0">{{ _trans('label.Status.Any') }}</option>
                </select>
                <button type="submit" @click.prevent="search" class="search-btn flex-none w-max md:ml-6">
                    {{ _trans('action.Search') }}
                </button>
            </div>
        </form>
    </div>
    <ag-grid-vue style="width: 100%;"
                 id="content-management-grid"
                 class="ag-theme-alpine w-full h-screen my-5 text-xs"
                 :gridOptions="gridOptions"
                 :context="context"
                 @grid-ready="onGridReady"
                 :columnDefs="columnDefs"
                 :frameworkComponents="frameworkComponents"
                 :defaultColDef="defaultColDef"
                 :animateRows="true"
                 :rowData="rowData">
    </ag-grid-vue>
</template>

<script>
import moment from 'moment'
import AdminLayout from "@layouts/AdminLayout"
import {AgGridVue} from "ag-grid-vue3"
import Button from "@components/Button"
import {publish, unpublish, archive, restore, forceDelete} from "../../../shared/ContentServices"
import SearchModel from "@models/SearchModel";
import SORTING_DIRECTION from "@models/CONSTANTS";
import AgGridEditIcon from "@components/AgGridExtensions/AgGridEditIcon";
import AgGridArchiveIcon from "@components/AgGridExtensions/AgGridArchiveIcon";
import AgGridPublishIcon from "@components/AgGridExtensions/AgGridPublishIcon";
import AgGridUnPublishIcon from "@components/AgGridExtensions/AgGridUnPublishIcon";
import AgGridDeleteIcon from "@components/AgGridExtensions/AgGridDeleteIcon";
import AgGridContentStatus from "@components/AgGridExtensions/AgGridContentStatus";
import AgGridPreviewIcon from "@components/AgGridExtensions/AgGridPreviewIcon";
import axios from 'axios'
import AgGridEmptyCol from "@components/AgGridExtensions/AgGridEmptyCol";
import AgGridRetoreIcon from "@components/AgGridExtensions/AgGridRetoreIcon";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "manage-roasting-service",
    components: {
        Button,
        'ag-grid-vue': AgGridVue
    },
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        pagingSize: {
            type: Number,
            default: 15
        }
    },
    data() {
        return {
            context: {},
            frameworkComponents: null,
            domLayout: "autoHeight",
            cacheOverFlowSize: this.pagingSize,
            infiniteInitialRowCount: this.pagingSize,
            maxConcurrentDatasourceRequests: 2,
            gridOptions: {
                cacheBlockSize: this.pagingSize,
                paginationPageSize: this.pagingSize,
                rowModelType: 'infinite',
                domLayout: this.domLayout,
                pagination: true,
                rowSelection: 'multiple',
                suppressMenuHide: true
            },
            gridApi: null,
            gridColumnApi: null,
            columnDefs: [
                {
                    headerName: 'Title', field: 'title', valueGetter: function (params) {
                        return params != null && params.node.data != null && params.node.data.contentable != null ? params.node.data.contentable.title : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Detail', field: 'detail', valueGetter: function (params) {
                        return params != null && params.node.data != null && params.node.data.contentable != null ? params.node.data.contentable.cms_lead_paragraph : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 300,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Video Link', field: 'video_link', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.contentable.video_link : 'N/A';
                    },
                    minWidth: 130,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Tags', field: 'tags', valueGetter: function (params) {
                        return params != null && params.node.data != null && params.node.data.tags != null ? params.node.data.tags.map(tag => tag.name).join(', ') : 'N/A';
                    },
                    // colId: 'params',
                    autoHeight: true,
                    sortable: false
                },
                {
                    headerName: 'Created Date', field: 'created_at', valueFormatter: function (params) {
                        return params != null && params.node.data != null ? moment(String(params.node.data.created_at)).format('MMM DD, YYYY') : 'N/A';
                    },
                    minWidth: 120,
                    // colId: 'params'
                },
                {
                    headerName: 'Published',
                    field: 'is_published',
                    // colId: 'params',
                    cellRenderer: 'contentStatusIcon'
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRenderer: 'previewIcon',
                    cellRendererParams: function (params) {
                        return {previewRoute: params.node.data != null ? route('preview-roasting-service', params.node.data.id) : ''}
                    },
                    // colId: 'id',
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRendererSelector: function (params) {
                        let publishBtn = {
                            component: 'publishIcon'
                        };

                        let unPublishBtn = {
                            component: 'unPublishIcon',
                        };

                        let emptyCol = {
                            component: 'emptyCol',
                        };

                        if (params.node.data != null && !params.node.data.is_published && !params.node.data.trashed)
                            return publishBtn;
                        else if (params.node.data != null && params.node.data.is_published && !params.node.data.trashed)
                            return unPublishBtn;
                        else
                            return emptyCol;
                    },
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRendererSelector: function (params) {
                        let editBtn = {
                            component: 'editIcon'
                        };

                        let archiveBtn = {
                            component: 'archiveIcon',
                        };

                        let restoreBtn = {
                            component: 'restoreIcon'
                        };
                        let emptyCol = {
                            component: 'emptyCol',
                        };

                        if (params.node.data != null && !params.node.data.is_published && !params.node.data.trashed)
                            return editBtn;
                        else if (params.node.data != null && params.node.data.is_published && !params.node.data.trashed)
                            return archiveBtn;
                        else if (params.node.data != null && params.node.data.is_published && params.node.data.trashed)
                            return restoreBtn;
                        else
                            return emptyCol;
                    },
                    cellRendererParams: function (params) {
                        return {editRoute: params.node.data != null && params.node.data.contentable != null ? route('roasting-service-editor-page', params.node.data.contentable.id) : ''}
                    },
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRenderer: 'deleteIcon',
                    sortable: false
                }
            ],
            defaultColDef: {
                flex: 1,
                minWidth: 70,
                resizable: true,
                sortable: true,
                filter: false,
                suppressSizeToFit: true,
            }
            ,
            rowData: [],
            params:
                null,
            searchModel: new SearchModel([], this.pagingSize, 0, {}, [], [], 'published_at', SORTING_DIRECTION.DESCENDING),
            progressMessage:
                ''
        }
    },

    beforeMount() {
        this.context = {
            componentParent: this
        };
        this.frameworkComponents = {
            editIcon: AgGridEditIcon,
            publishIcon: AgGridPublishIcon,
            unPublishIcon: AgGridUnPublishIcon,
            deleteIcon: AgGridDeleteIcon,
            archiveIcon: AgGridArchiveIcon,
            contentStatusIcon: AgGridContentStatus,
            previewIcon: AgGridPreviewIcon,
            emptyCol: AgGridEmptyCol,
            restoreIcon: AgGridRetoreIcon
        };
        this.searchModel.simpleFilters['content_status'] = 0;
        this.searchModel.simpleFilters['search_keyword'] = '';
    },
    methods: {
        setRowsHeight() {
            let gridHeight = 0;
            this.gridOptions.api.forEachNode(node => {
                let rowHeight = this.gridOptions.getRowHeight(node);
                node.setRowHeight(rowHeight);
                node.setRowTop(gridHeight);
                gridHeight += rowHeight;
            });
            if (!gridHeight) {
                return;
            }
            this.gridApi.onRowHeightChanged();
        },
        getRowHeight(node) {
            return (Math.floor(node.data.contentable.detail.length / 7) + 1);
        },
        publishRow(contentId) {
            if (confirm("Are you sure you want to publish the content?")) {
                publish(contentId).then(
                    (response) => {
                        this.$toast.success('Content is published successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        unPublishRow(contentId) {
            if (confirm("Are you sure you want to un-publish the content?")) {
                unpublish(contentId).then(
                    (response) => {
                        this.$toast.success('Content is un-published successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        archiveRow(contentId) {
            if (confirm("Are you sure you want to archive the content?")) {
                archive(contentId).then(
                    (response) => {
                        this.$toast.success('Content is archived successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        restoreRow(contentId) {
            if (confirm("Are you sure you want to restore the content?")) {
                restore(contentId).then(
                    (response) => {
                        this.$toast.success('Content is restored successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        forceDeleteRow(contentId) {
            if (confirm("Are you sure you want to delete the content?")) {
                forceDelete(contentId).then(
                    (response) => {
                        this.$toast.success('Content is deleted successfully!');
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        gotoPage(page) {
            this.form.page = page;
            this.search();
        },
        onGridReady: function (params) {
            this.params = params;
            this.gridApi = params.api;
            this.gridColumnApi = params.columnApi;
            this.gridApi.sizeColumnsToFit();
            let dataSource = {
                getRows: (params) => {
                    // build search model
                    this.buildSearchModel(params);

                    // call a service to get list of users
                    axios.post(route('fetch-roasting-service'), this.searchModel).then(res => {
                        let result = res.data;
                        this.searchModel.currentPage = res.data.current_page;
                        params.successCallback((result && result.data) ? result.data : [], (result && result.total) ? result.total : 0);

                        if (result.total == 0)
                            this.gridApi.showNoRowsOverlay();
                        else
                            this.gridApi.hideOverlay();
                    });
                }
            };
            this.gridApi.setDatasource(dataSource);
        },
        search() {
            this.onGridReady(this.params);
        },
        onColumnResized(params) {
            params.api.resetRowHeights();
        },
        onColumnVisible(params) {
            params.api.resetRowHeights();
        },
        sizeToFit() {
            this.gridApi.sizeColumnsToFit();
        },
        autoSizeAll(skipHeader) {
            let allColumnIds = [];
            this.gridColumnApi.getAllColumns().forEach(function (column) {
                allColumnIds.push(column.colId);
            });
            this.gridColumnApi.autoSizeColumns(allColumnIds, skipHeader);
        },
        buildSearchModel(params) {
            this._buildSearchModel(params.filterModel, params.sortModel, params.startRow, this.gridOptions.paginationPageSize);
        },
        _buildSearchModel(filterModel, sortModel, startRow = null, pageSize = null) {
            if (startRow != null && pageSize != null) {
                this.searchModel.currentPage = Math.ceil(startRow / pageSize);
                this.searchModel.pageSize = pageSize;
            } else {
                this.searchModel.currentPage = -1;
            }

            if (sortModel != null) {
                sortModel.forEach((element) => {
                    if (element.sort === "asc" || element.sort === "desc") {
                        this.searchModel.sortingColumn = element.colId;
                        this.searchModel.sortingDirection = element.sort === "asc" ? SORTING_DIRECTION.ASCENDING : SORTING_DIRECTION.DESCENDING;
                    } else {
                        this.searchModel.sortingColumn = "";
                        this.searchModel.sortingDirection = null;
                    }
                });
            } else {
                this.searchModel.sortingDirection = SORTING_DIRECTION.DESCENDING;
                this.searchModel.sortingColumn = "published_at";
            }

            this.searchModel.simpleFilters = this.searchModel.simpleFilters ? this.searchModel.simpleFilters : {};
            this.searchModel.collectionFilters = this.searchModel.collectionFilters ? this.searchModel.collectionFilters : {};

            Object.keys(filterModel).forEach((key) => {
                if (typeof filterModel[key] == 'string') {
                    this.searchModel.simpleFilters[key] = this.gridApi.getFilterInstance(key).appliedModel ? this.gridApi.getFilterInstance(key).appliedModel.filter : this.gridApi.getFilterInstance(key).getModel().value;
                } else {
                    this.searchModel.collectionFilters[key] = this.gridApi.getFilterInstance(key).appliedModel ? this.gridApi.getFilterInstance(key).appliedModel.filter : this.gridApi.getFilterInstance(key).getModel().value;
                }
            });

        },
    }
})
</script>

<style src="ag-grid-community/dist/styles/ag-grid.css"></style>
<style src="ag-grid-community/dist/styles/ag-theme-alpine.css"></style>

