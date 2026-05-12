'use strict';

/**
 * Plot result from the beam analysis calculation into a graph
 */
class AnalysisPlotter {
    constructor(container) {
        this.container = container;
        this.chart = null;
    }

    /**
     * Plot equation.
     *
     * @param {Object{beam : Beam, load : float, equation: Function}}  The equation data
     */
    plot(data) {
        // console.log('Plotting data : ', data);

        let labels = [];
        let values = [];

        let beamLenght = data.beam.primarySpan;
        // let l1

        if(data.beam.secondarySpan) {
            beamLenght += data.beam.secondarySpan;
        }

        for(let x = 0; x <= beamLenght; x += 0.1) {
            let point = data.equation(x);

            labels.push(point.x.toFixed(2));
            values.push(point.y);
        }

        const ctx = document.getElementById(this.container);

        if(this.chart) {
            this.chart.destroy();
        }

        this.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: this.container,
                    data: values,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'x'
                        }
                    },
                    y: {
                        title:{
                            display: true,
                            text: 'y'
                        }
                    }
                }
            }
        })
    }
}