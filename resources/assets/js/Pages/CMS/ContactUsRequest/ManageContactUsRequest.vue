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
                <li>{{ _trans('label.shared.Contact Us Requests') }}</li>
            </ul>
        </div>

        <form class="flex flex-wrap w-full py-8">
            <div class="form-group sm:w-full md:w-1/2 md:pr-6">
                <input type="text" v-model="searchModel.simpleFilters['search_keyword']" class="form-control w-full"
                       :placeholder="_trans('label.shared.Search Keyword')"/>
            </div>
            <div class="form-group sm:my-4 md:my-0 sm:w-full md:w-1/2 flex flex-wrap justify-end items-center">
                <select type="text" v-model="searchModel.simpleFilters['content_status']"
                        class="form-control flex-grow sm:w-full md:w-max sm:mb-4 md:mb-0">
                    <option value="1">{{ _trans('label.Status.Open') }}</option>
                    <option value="2">{{ _trans('label.Status.Closed') }}</option>
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
import {
    closeRequest,
    openRequest,
    forceDeleteRequest,
    archiveRequest
} from "../../../shared/ContentServices"
import SearchModel from "@models/SearchModel";
import SORTING_DIRECTION from "@models/CONSTANTS";
import AgGridLockIcon from "@components/AgGridExtensions/AgGridLockIcon";
import AgGridUnlockIcon from "@components/AgGridExtensions/AgGridUnlockIcon";
import AgGridDeleteIcon from "@components/AgGridExtensions/AgGridDeleteIcon";
import AgGridDetailIcon from "@components/AgGridExtensions/AgGridDetailIcon";
import AgGridArchiveRequestIcon from "@components/AgGridExtensions/AgGridArchiveRequestIcon";
import axios from 'axios'
import AgGridEmptyCol from "@components/AgGridExtensions/AgGridEmptyCol";
import AgGridForceDeleteRequestIcon from "@components/AgGridExtensions/AgGridForceDeleteRequestIcon";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "manage-contact-us-request",
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
                rowHeight: 80,
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
                    headerName: 'Full Name', field: 'first_name', valueGetter: function (params) {
                        return params != null && params.node.data != null ? (params.node.data.first_name) + ' ' + (params.node.data.middle_name) + ' ' + (params.node.data.last_name) : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Email', field: 'email', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.email : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Company Name', field: 'company_name', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.company_name : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Professional Area', field: 'professional_area', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.professional_area : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Phone Number', field: 'phone_number', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.phone_number : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Country', field: 'country', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.country.display_name : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 200,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Comment', field: 'detail', valueGetter: function (params) {
                        return params != null && params.node.data != null ? params.node.data.cms_lead_paragraph : 'N/A';
                    },
                    // colId: 'params',
                    minWidth: 300,
                    autoHeight: true,
                    wrapText: true
                },
                {
                    headerName: 'Status', field: 'Status', valueGetter: function (params) {
                        return params != null && params.node.data != null ? (params.node.data.status == 1 ? 'Open' : 'Closed') : 'N/A';
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
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRenderer: 'detailIcon',
                    cellRendererParams: function (params) {
                        if (params.node != null)
                            return {detailRoute: params.node.data != null ? route('contact-us-request-detail', params.node.data.id) : ''}
                    },
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRendererSelector: function (params) {
                        let lockBtn = {
                            component: 'lockIcon'
                        };
                        let unlockBtn = {
                            component: 'unlockIcon',
                        };
                        let emptyCol = {
                            component: 'emptyCol',
                        };
                        if (params.node.data != null && params.node.data.status && !params.node.data.trashed)
                            return lockBtn;
                        else if (params.node.data != null && !params.node.data.status && !params.node.data.trashed)
                            return unlockBtn;
                        else
                            return emptyCol;
                    },
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRenderer: 'deleteIcon',
                    sortable: false
                },
                {
                    headerName: '',
                    field: 'id',
                    // colId: 'params',
                    cellRendererSelector: function (params) {
                        let archiveBtn = {
                            component: 'archiveIcon',
                        };
                        let emptyCol = {
                            component: 'emptyCol',
                        };
                        if (params.node.data != null && !params.node.data.status && !params.node.data.trashed)
                            return archiveBtn;
                        else
                            return emptyCol;
                    },
                    sortable: false
                },
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
            searchModel: new SearchModel([], this.pagingSize, 0, {}, [], [], 'created_at', SORTING_DIRECTION.DESCENDING),
            progressMessage:
                ''
        }
    },
    beforeMount() {
        this.context = {
            componentParent: this
        };

        this.frameworkComponents = {
            lockIcon: AgGridLockIcon,
            deleteIcon: AgGridForceDeleteRequestIcon,
            unlockIcon: AgGridUnlockIcon,
            detailIcon: AgGridDetailIcon,
            archiveIcon: AgGridArchiveRequestIcon,
            emptyCol: AgGridEmptyCol,
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
            return (Math.floor(node.data.detail.length / 7) + 1);
        },
        closeRow(contentId) {
            if (confirm('Are you sure you want to close this contact us request ?')) {
                closeRequest(contentId).then(
                    (response) => {
                        this.$toast.success('Contact Us Request is closed successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        openRow(contentId) {
            if (confirm('Are you sure you want to open this contact us request ?')) {
                openRequest(contentId).then(
                    (response) => {
                        this.$toast.success('Contact Us Request is opened successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        archiveRow(contentId) {
            if (confirm('Are you sure you want to archive this contact us request ?')) {
                archiveRequest(contentId).then(
                    (response) => {
                        this.$toast.success('Contact Us Request is archived successfully!')
                        this.onGridReady(this.params)
                    },
                    (error) => {
                    }
                )
            }
        },
        deleteRow(contentId) {
            if (confirm('Are you sure you want to permanently delete this contact us request ?')) {
                forceDeleteRequest(contentId).then(
                    (response) => {
                        this.$toast.success('Contact Us Request is deleted successfully!');
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
                    axios.post(route('fetch-contact-us-request'), this.searchModel).then(res => {
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
                this.searchModel.sortingColumn = "created_at";
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

