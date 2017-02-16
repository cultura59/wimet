
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


const appPublica = angular.module("appPublica", []);
appPublica.controller('publicaCtrl', ['$scope','$http', function($scope, $http) {
	getAccess();
	getAccessibilities();
	getCategorias();
	getEstilos();
	getAmenities();
	getCharacteristics();
	getRules();

	$scope.step = "primer-paso";
	const vistas = [
						"primer-paso", 
						"segundo-paso", 
						"tercer-paso", 
						"cuarto-paso", 
						"quinto-paso", 
						"sexto-paso", 
						"septimo-paso",
						"octavo-paso",
						"noveno-paso",
					];
	$scope.espacio = {
		user_id: null,
		name: '',
		description: '',
		categorias: [],
		quanty: 0,
		adress: '',
		country: '',
		state: '',
		city: '',
		lat: null,
		long: null
	};
	$scope.progress = 0;
	$scope.progressbar = '';

	//--------------- Funciones del front -------------//
	$scope.setCategoria = function(categoria) {
		var exist = $scope.espacio.categorias.indexOf(categoria);
		
		if(exist > -1) {
			$scope.espacio.categorias.splice(exist, 1);
		}else {
			$scope.espacio.categorias.push(categoria);
		}
	};

	$scope.previewStep = () => {
		let aux = vistas.indexOf($scope.step);
		$scope.step = vistas[aux - 1];
		$scope.progress = $scope.progress - 10;
		$scope.progressbar = `width: ${$scope.progress}%`;
	};

	$scope.nextStep = () => {
		let aux = vistas.indexOf($scope.step);
		$scope.step = vistas[aux + 1];
		$scope.progress = $scope.progress + 10;
		$scope.progressbar = `width: ${$scope.progress}%`;
	};

	$scope.isActiveMenu = (step) => {
		if(step === $scope.step)
		{
			return "active";
		}
	};

	$scope.isCategorySelected = (categoria) => {
		var exist = $scope.espacio.categorias.indexOf(categoria);
		
		if(exist > -1) {
			return "selectedCategory";
		}
	};

	$scope.saveEspacio = () => {
		$http({
			method: 'POST',
			url: '/api/espacio',
			data: $scope.espacio
		}).then(function successCallback(res) {
			$scope.espacio = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	//------------------- Helppers ----------------------//

	function getLongLat(street) {
		$http({
			method: 'GET',
			url: `http://maps.google.com/maps/api/geocode/json?address=${street}&sensor=false`
		}).then(function successCallback(res) {
			
			$scope.espacio.lat = res.data.results[0].geometry.location.lat;
			$scope.espacio.long = res.data.results[0].geometry.location.lng;

			let dataState = res.data.results[0].address_components;
			
			dataState.forEach( (datos) => {

				if(datos.types[0] === "administrative_area_level_2") {
					$scope.espacio.cuidad = datos.long_name;
				}

				if(datos.types[0] === "administrative_area_level_1") {
					$scope.espacio.provincia = datos.long_name;
				}
			
				if(datos.types[0] === "country") {
					$scope.espacio.pais = datos.long_name;
				}

			});

		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getCategorias() {
		$http({
			method: 'GET',
			url: '/api/categoria'
		}).then(function successCallback(res) {
			$scope.categorias = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getEstilos() {
		$http({
			method: 'GET',
			url: '/api/estiloespacio'
		}).then(function successCallback(res) {
			$scope.estiloespacio = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getAccessibilities() {
		$http({
			method: 'GET',
			url: '/api/accessibilities'
		}).then(function successCallback(res) {
			$scope.accessibilities = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getAccess() {
		$http({
			method: 'GET',
			url: '/api/access'
		}).then(function successCallback(res) {
			$scope.access = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getAmenities() {
		$http({
			method: 'GET',
			url: '/api/servicio'
		}).then(function successCallback(res) {
			$scope.amenities = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getCharacteristics() {
		$http({
			method: 'GET',
			url: '/api/characteristics'
		}).then(function successCallback(res) {
			$scope.characteristics = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};

	function getRules() {
		$http({
			method: 'GET',
			url: '/api/rules'
		}).then(function successCallback(res) {
			$scope.rules = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});
	};
}]);


const appEspacio = angular.module("appEspacio", []);
appEspacio.controller('espacioCtrl', ['$scope', '$http', ($scope, $http) => {
	sessionStorage.removeItem('espacioreserva');
	$scope.datesTimes = [];
	
	$scope.setPrice = (price, id) => {
		$scope.espacio_id = id;
		$scope.price = price;
		$scope.houres = 1;
		$scope.subTotal = $scope.price * $scope.houres;
		$scope.fee = ($scope.subTotal * 5)/100;
		$scope.total = $scope.subTotal + $scope.fee;
	};

	$scope.addDateTimes = () => {
		$scope.houres = $scope.houres + ($scope.fin - $scope.inicio);
		$scope.subTotal = $scope.price * $scope.houres;
		$scope.fee = ($scope.subTotal * 5)/100;
		$scope.total = $scope.subTotal + $scope.fee;

		$scope.datesTimes.push({
			'date': $scope.date,
			'inicio': $scope.inicio,
			'fin': $scope.fin
		});
		$scope.date		= '';
		$scope.inicio	= '';
		$scope.fin		= '';
	};

	$scope.convertDate = (date) => {
		var d = new Date(date || Date.now()),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

	    if (month.length < 2) month = '0' + month;
	    if (day.length < 2) day = '0' + day;

	    return [month, day, year].join('/');
	};

	$scope.reservar = () => {
		$scope.espacioReserva = {
			espacioId: $scope.espacio_id,
			price: $scope.price,
			houres: $scope.houres,
			subTotal: $scope.subTotal,
			fee: $scope.fee,
			total: $scope.total,
			datesTimes: $scope.datesTimes
		};
		sessionStorage.setItem('espacioreserva', JSON.stringify($scope.espacioReserva));
		window.location = `/espacio/${$scope.espacio_id}/reserva`;
	};
}]);

const appReserva = angular.module("appReserva", []);
appReserva.controller('reservaCtrl', ['$scope', '$http', ($scope, $http) => {
	
	$scope.espacioreserva = JSON.parse(sessionStorage.espacioreserva);
	$scope.showModal = false;

	$scope.reservaFinal = {
		datos: JSON.parse(sessionStorage.espacioreserva),
		quanty: 0,
		comment: ''
	};

	$scope.convertDate = (date) => {
		var d = new Date(date || Date.now()),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

	    if (month.length < 2) month = '0' + month;
	    if (day.length < 2) day = '0' + day;

	    return [month, day, year].join('/');
	};

	$scope.sendReserva = () => {
		document.getElementById("reservaModal").style.display = "block";
		console.log("entro");
		/*$http({
			method: 'POST',
			url: '/api/categoria',
			data: $scope.reservaFinal
		}).then(function successCallback(res) {
			$scope.categorias = res.data;
		}, function errorCallback(res) {
			console.log(res);
		});*/
	};
}]);