
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
		categorias: [],
		capacidad: '',
		ubicacion: '',
		tipo: '',
		resumen: '',
		pais: '',
		provincia: '',
		ciudad: '',
		lat: '',
		long: ''
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

	//------------------- Helppers ----------------------//

	function getLongLat(street) {
		$http.get('http://maps.google.com/maps/api/geocode/json?address=' + street + '&sensor=false')
		.success(function(res) {
			$scope.espacio.lat = res.results[0].geometry.location.lat;
			$scope.espacio.long = res.results[0].geometry.location.lng;
		});
	};
}]);


const appEspacio = angular.module("appEspacio", []);

appEspacio.controller('espacioCtrl', ['$scope', '$http', ($scope, $http) => {
	$scope.datesTimes = [];
	
	$scope.setPrice = (price) => {
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
}]);