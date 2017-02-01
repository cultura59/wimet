
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

const appPublica = angular.module("appPublica", []);
appPublica.controller('publicaCtrl', ['$scope','$http', function($scope, $http) {
	$scope.categorias = {};
	$scope.step = "primer-paso";
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

	$http({
		method: 'GET',
		url: '/api/categoria'
	}).then(function successCallback(res) {
		$scope.categorias = res.data;
	}, function errorCallback(res) {
		console.log(res);
	});

	//--------------- Funciones del front -------------//
	$scope.setCategoria = function(categoria) {
		var exist = $scope.espacio.categorias.indexOf(categoria);
		
		if(exist > -1) {
			$scope.espacio.categorias.splice(exist, 1);
		}else {
			$scope.espacio.categorias.push(categoria);
		}
	};

	$scope.setStep = (step) => {
		if(step === "segundo-paso")
		{
			getLongLat($scope.espacio.adress);
		}

		if(step === "tercer-paso") {

			$scope.saveEspacio();
		}

		$scope.step = step;
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