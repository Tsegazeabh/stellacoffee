import moment from "moment";

export const DateServices = {
    formatDate: function (date) {
        return moment(String(date)).format('MMM DD, YYYY')
    }
}
