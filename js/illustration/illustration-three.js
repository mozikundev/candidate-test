import * as THREE from 'three';
import { FBXLoader } from 'three/addons/loaders/FBXLoader.js';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { CSS2DRenderer, CSS2DObject } from 'three-css2d';

// const scene = new THREE.Scene();
// const camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

// const renderer = new THREE.WebGLRenderer();
// renderer.setSize( window.innerWidth, window.innerHeight );
// renderer.setAnimationLoop( animate );
// document.body.appendChild( renderer.domElement );

// function animate() {
//     requestAnimationFrame(animate);
// 	renderer.render( scene, camera );
// }

class IllustrationThree {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;

        this.init();
    }

    init() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x000000);

        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        const aspect = width/height;

        this.camera = new THREE.PerspectiveCamera(35, aspect, 0.1, 1000);
        this.camera.position.set(4, 2, 3);

        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.container.appendChild(this.renderer.domElement);

        this.labelRenderer = new CSS2DRenderer();
        this.labelRenderer.setSize(width, height);
        this.labelRenderer.domElement.style.position = 'absolute';
        this.labelRenderer.domElement.style.top = '0px';
        this.labelRenderer.domElement.style.pointerEvents = 'none';
        this.container.appendChild(this.labelRenderer.domElement);

        // const axesHelper = new THREE.AxesHelper(10);
        this.scene.add(new THREE.AxesHelper(5));

        const ambientLight = new THREE.AmbientLight(0xffffff, 1);
        this.scene.add(ambientLight);

        const dirLight = new THREE.DirectionalLight(0xffffff, 0.5);
        dirLight.position.set(10, 10, 10);
        this.scene.add(dirLight);

        const loader = new FBXLoader();
        loader.load('model/wood/wood.fbx', (object) => {
            object.scale.set(1, 1, 1);
            object.position.set(0, 0, 0);

            const woodRight = object.clone();
            woodRight.scale.set(3, 0.2, 0.5);
            woodRight.position.set(-3, 0.2, 0.5);
            this.addOutline(woodRight);
            this.scene.add(woodRight);

            const woodLeftFront = object.clone();
            woodLeftFront.scale.set(2, 0.2, 0.5);
            woodLeftFront.position.set(-3.54, 0.2, 1.51);
            this.addOutline(woodLeftFront);
            this.scene.add(woodLeftFront);

            const woodTop = object.clone();
            woodTop.scale.set(2, 0.2, 0.4);
            woodTop.position.set(-3.7, 0.61, 1.1);
            this.addOutline(woodTop);
            this.scene.add(woodTop);

            // this.addDimensionHelpers(object);
            // this.createDimension(new THREE.Vector3(0, -0.5, 1), new THREE.Vector3(2.1, -0.5, 1), "2.1m");
            // this.createDimension(new THREE.Vector3(2.3, 0, 0), new THREE.Vector3(2.3, 1, 0), "0.2m");
        }, (xhr) => {
            console.log((xhr.loaded / xhr.total * 100) + '% loaded');
        }, (error) => {
            console.error("Failed to load FBX model: ", error);
        });

        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.target.set(-2, 0, 1);
        this.controls.update();
        this.animate();
    }

    createDimension(start, end, text) {
        const material = new THREE.LineBasicMaterial({ color: 0xffffff});
        const geometry = new THREE.BufferGeometry().setFromPoints([start, end]);
        const line = new THREE.Line(geometry, material);
        this.scene.add(line);

        const textDiv = document.createElement('div');
        textDiv.className = 'dim-label';
        textDiv.textContent = text;

        const label = new CSS2DObject(textDiv);

        const midPoint = new THREE.Vector3().addVectors(start, end).multiplyScalar(0.5);
        label.position.copy(midPoint);
        this.scene.add(label);
    }

    addDimensionHelpers(model) {
        const material = new THREE.LineBasicMaterial({ color: 0xffffff});

        const points = [];
        points.push(new THREE.Vector3(0, 0, 0));
        points.push(new THREE.Vector3(2, 0, 0));

        const geometry = new THREE.BufferGeometry().setFromPoints(points);
        const line = new THREE.Line(geometry, material);
        this.scene.add(line);
    }

    addOutline(object) {
        object.traverse((node) => {
            if(node.isMesh) {
                const edges = new THREE.EdgesGeometry(node.geometry);
                const line = new THREE.LineSegments(edges, new THREE.LineBasicMaterial({ color: 0xffffff }));
                node.add(line);
            }
        });
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        if(this.controls) this.controls.update();
        if(this.renderer) this.renderer.render(this.scene, this.camera);
        if(this.labelRenderer) this.labelRenderer.render(this.scene, this.camera);
    }
}

new IllustrationThree('illustration-3d-container');