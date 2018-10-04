/**
 * Created by kat on 26.09.18.
 */
// MonthlyIncome.js
import { Pie, mixins } from 'vue-chartjs'

export default {
    extends: Pie,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
    mounted () {
        this.renderChart(this.chartData, this.options)
    }
}