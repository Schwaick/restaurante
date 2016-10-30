var app = angular.module("app", []); 

app.controller("controller", function($scope,$filter,$http) {
	$scope.mostrarMesas = false;
	$scope.imagens = [];
	$http.get("getMesas.php")
	.then(function (response) {
		$scope.imagens = response.data;
	});

	$scope.selecionado = {};

	$scope.selecionar = function(imagem) {
		$scope.selecionado = imagem;
		var found = $filter('filter')($scope.reservas, {mesa_id: imagem.id}, true);
		$scope.reserva = found[0];
		$scope.reserva.prato = found[0].prato.replace('lasanha','Lasanha')
		.replace('macarronada','Macarronada').replace('arrozfeijao','Arroz e feijão');
	}

	$scope.pesquisar = function() {
		var imagens = $scope.imagens;
		for (var i = 0; i < imagens.length; i++) {
			imagens[i].imagem_source = $filter('imagemCorreta')(imagens[i].imagem_source,'verde');
		}
		$scope.mostrarMesas = true;

		var valor_data = $filter('date')(new Date($scope.data),'yyyy-MM-dd');
		var valor_hora = $filter('date')(new Date($scope.hora),'HH:mm:ss');

		var data = {
			params: { data:valor_data, hora:valor_hora }
		};

		$http.get("getReservas.php",data)
		.then(function (response) {
			$scope.reservas = response.data;
			var reservas = response.data;
			for (var i = 0; i < reservas.length; i++) {
				var found = $filter('filter')($scope.imagens, {id: reservas[i].mesa_id}, true);
				if (found.length) {
					found[0].imagem_source = $filter('imagemCorreta')(found[0].imagem_source,'vermelho');
				}
			}

			var todos = true;
			for (var i = 0; i < $scope.imagens.length; i++) {
				if($scope.imagens[i].imagem_source.indexOf('verde') !== -1) {
					todos = false;
				}
			}

			if(todos) alert('Todas as mesas estão reservadas!');
		});

		$scope.max = $filter('horaMaisDois')($scope.hora);
	}

	$scope.reservar = function(nome,numero,termino,prato) {
		var valor_data = $filter('date')(new Date($scope.data),'yyyy-MM-dd');
		var valor_hora = $filter('date')(new Date($scope.hora),'HH:mm:ss');
		var valor_reserva = $filter('date')(new Date(termino),'HH:mm:ss');
		var data = {
			params: { 
				mesa:$scope.selecionado.id,
				nome:nome, 
				numero:numero, 
				prato:prato,
				data:valor_data, 
				hora:valor_hora,
				termino:valor_reserva 
			}
		};

		$http.get("setReserva.php",data)
		.then(function (response) {
			if(response.data) {
				var newData = {
					params: { data:valor_data, hora:valor_hora }
				};
				$http.get("getReservas.php",data)
				.then(function (response) {$scope.reservas = response.data;});
				$scope.selecionado.imagem_source = $filter('imagemCorreta')($scope.selecionado.imagem_source,'vermelho');
			}
		});

		$("#myModal").modal('hide');
	}
});

app.filter('horaMaisDois', function() {
	return function(hora) {
		return new Date(2016,1,1,hora.getHours()+2,hora.getMinutes(),0,0);
	};
});

app.filter('imagemCorreta', function() {
	return function(imagem,cor) {
		if(imagem.indexOf('1') !== -1) {
			imagem = cor+"1.png";
		}
		else if(imagem.indexOf('2') !== -1) {
			imagem = cor+"2.png";
		}

		return imagem;
	};
});