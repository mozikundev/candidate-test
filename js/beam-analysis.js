'use strict';

/** ============================ Beam Analysis Data Type ============================ */

/**
 * Beam material specification.
 *
 * @param {String} name         Material name
 * @param {Object} properties   Material properties {EI : 0, GA : 0, ....}
 */
class Material {
    constructor(name, properties) {
        this.name = name;
        this.properties = properties;
    }
}

/**
 *
 * @param {Number} primarySpan          Beam primary span length
 * @param {Number} secondarySpan        Beam secondary span length
 * @param {Material} material           Beam material object
 */
class Beam {
    constructor(primarySpan, secondarySpan, material) {
        this.primarySpan = primarySpan;
        this.secondarySpan = secondarySpan;
        this.material = material;
    }
}

/** ============================ Beam Analysis Class ============================ */

class BeamAnalysis {
    constructor() {
        this.options = {
            condition: 'simply-supported'
        };

        this.analyzer = {
            'simply-supported': new BeamAnalysis.analyzer.simplySupported(),
            'two-span-unequal': new BeamAnalysis.analyzer.twoSpanUnequal()
        };
    }
    /**
     *
     * @param {Beam} beam
     * @param {Number} load
     */
    getDeflection(beam, load, condition) {
        var analyzer = this.analyzer[condition];

        if (analyzer) {
            return {
                beam: beam,
                load: load,
                equation: analyzer.getDeflectionEquation(beam, load)
            };
        } else {
            throw new Error('Invalid condition');
        }
    }
    getBendingMoment(beam, load, condition) {
        var analyzer = this.analyzer[condition];

        if (analyzer) {
            return {
                beam: beam,
                load: load,
                equation: analyzer.getBendingMomentEquation(beam, load)
            };
        } else {
            throw new Error('Invalid condition');
        }
    }
    getShearForce(beam, load, condition) {
        var analyzer = this.analyzer[condition];

        if (analyzer) {
            return {
                beam: beam,
                load: load,
                equation: analyzer.getShearForceEquation(beam, load)
            };
        } else {
            throw new Error('Invalid condition');
        }
    }
}




/** ============================ Beam Analysis Analyzer ============================ */

/**
 * Available analyzers for different conditions
 */
BeamAnalysis.analyzer = {};

/**
 * Calculate deflection, bending stress and shear stress for a simply supported beam
 *
 * @param {Beam}   beam   The beam object
 * @param {Number}  load    The applied load
 */
BeamAnalysis.analyzer.simplySupported = class {
    constructor(beam, load) {
        this.beam = beam;
        this.load = load;
    }
    getDeflectionEquation(beam, load) {
        return function (x) {
            let L = beam.primarySpan;
            let EI = beam.material.properties.EI / Math.pow(1000.3);
            let j2 = beam.material.properties.j2 || 1;
            let y = -((load * x) / (24 * EI)) * (Math.pow(L, 3) - (2 * L * Math.pow(x, 2)) + Math.pow(x, 3)) * j2 * 1000;

            return {
                x: x,
                y: y
            };
        };
    }
    getBendingMomentEquation(beam, load) {
        return function (x) {
            let L = beam.primarySpan;

            return {
                x: x,
                y: -((load * x) / 2) * (L - x)
            };
        };
    }
    getShearForceEquation(beam, load) {
        return function (x) {
            let L = beam.primarySpan;

            return {
                x: x,
                y: load * ((L / 2) - x)
            };
        };
    }
};


/**
 * Calculate deflection, bending stress and shear stress for a beam with two spans of equal condition
 *
 * @param {Beam}   beam   The beam object
 * @param {Number}  load    The applied load
 */
BeamAnalysis.analyzer.twoSpanUnequal = class {
    constructor(beam, load) {
        this.beam = beam;
        this.load = load;
    }
    getDeflectionEquation(beam, load) {
        return function (x) {
            let l1 = beam.primarySpan;
            let l2 = beam.secondarySpan;
            let w = load;
            let EI = beam.material.properties.EI / Math.pow(1000, 3);
            let j2 = beam.material.properties.j2 || 1;

            let M1 = -((w * Math.pow(l2, 3)) + (w * Math.pow(l1, 3))) / (8 * (l1 + l2));
            let R1 = (M1 / l1) + ((w * l1) / 2);
            let R2 = (w * l1) + (w * l2) - R1 - ((M1 / l2) + ((w * l2) / 2));
            
            let y;

            if(x <= l1) {
                y = (x / (24 * EI)) * (4 * R1 * Math.pow(x, 2) - (w * Math.pow(x, 3)) - (4 * R1 * Math.pow(l1, 2)));
            }else{
                y = ((R1 * x / 6) * (Math.pow(l1, 2))) + ((R2 * x / 6) * (Math.pow(x, 2) - 3 * l1 * x + 3 * Math.pow(l1, 2))) - ((R2 * Math.pow(l1, 3) / 6)) - ((w * x / 24) * (Math.pow(x, 3) - Math.pow(l1, 3)));
            }

            return {
                x: x,
                y: y
            };
        };
    }
    getBendingMomentEquation(beam, load) {
        return function (x) {
            let l1 = beam.primarySpan;
            let w = load;

            let l2 = beam.secondarySpan;
            let M1 = -((w * Math.pow(l2, 3)) + (w * Math.pow(l1, 3))) / (8 * (l1 + l2));
            let R1 = (M1 / l1) + ((w * l1) / 2);
            let R2 = (w * l1) + (w * l2) - R1 - ((M1 / l2) + ((w * l2) / 2));

            let y;

            if(x <= l1) {
                y = (R1 * x) - (0.5 * w * Math.pow(x, 2));
            }else{
                y = (R1 * x) + (R2 * (x - l1)) - (0.5 * w * Math.pow(x, 2));
            }

            return {
                x: x,
                y: y
            };
        };
    }
    getShearForceEquation(beam, load) {
        return function (x) {
            let l1 = beam.primarySpan;
            let w = load;

            let l2 = beam.secondarySpan;
            let M1 = -((w * Math.pow(l2, 3)) + (w * Math.pow(l1, 3))) / (8 * (l1 + l2));
            let R1 = (M1 / l1) + ((w * l1) / 2);
            let R2 = (w * l1) + (w * l2) - R1 - ((M1 / l2) + ((w * l2) / 2));
            
            let y;

            if(x <= l1) {
                y = R1 - (w * x);
            }else{
                y = R1 + R2 - (w * x);
            }

            return {
                x: x,
                y: y
            };
        };
    }
};
