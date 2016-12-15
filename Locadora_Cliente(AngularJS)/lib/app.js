// Util 
var arraysEqual = function(a, b) {	
	if (a == null || b == null) return false;
	if (a === b) return true;
	if (a.length != b.length) return false;

  // If you don't care about the order of the elements inside
  // the array, you should sort both arrays here.

  for (var i = 0; i < a.length; ++i) {
  	if (a[i] !== b[i]) return false;
  }
  return true;
}
// Definindo APP
const app = angular.module("locadora",["ngMessages","ngLocale",'ngSanitize']).service('store',function(){

	var Clientes = [],
	Filmes = [],
	Locacoes = [],
	Timer;


	return {
		getClientes: function () {
			return Clientes;
		},
		setClientes: function(value) {
			Clientes = value;
		}, getFilmes: function () {
			return Filmes;
		},
		setFilmes: function(value) {
			Filmes = value;
		}, getLocacoes: function () {
			return Locacoes;
		},
		setTimer: function(value) {
			Timer = value;
		}, getTimer: function () {
			return Timer;
		},
		setTimer: function(value) {
			Timer = value;
		}
	};	
});
const $serverUrl = "http://localhost:8000/",
$token = 123456789;
app.config(['$qProvider', function ($qProvider) {
	$qProvider.errorOnUnhandledRejections(false);
}]);

// Primeiro controlador 

var appController = app.controller('AppController',function($scope,$http,$filter,store){
	$scope.appName = "Locadora Extreme"; 
	$scope.getClientes = function () {
		return store.getClientes();
	};
	$scope.setClientes = function (value) {
		return store.setClientes(value);
	};
	$scope.getFilmes = function () {
		return store.getFilmes();
	};
	$scope.setFilmes = function (value) {
		return store.setFilmes(value);
	};

    // Querys

    $scope.queryFilmes = "",
    $scope.queryClientes = "",
    $scope.queryLocacoes = "",
    $scope.sortFilmes = {
    	order : true,
    	term : "titulo"
    }, $scope.sortClientes = {
    	order : true,
    	term : "nome"
    }, $scope.sortLocacoes = {
    	order : true,
    	term : "id_cliente"
    },
    $scope.ordernarPor = function(term,sort){
    	if(sort.term == term){
    		sort.order = !sort.order;
    	}
    	else{
    		sort.term = term;
    	}
    },$scope.showIconOrder = function(term,sort){
    	if(sort.term == term){
    		return '<i class="material-icons tiny">sort</i>';
    	}
    	return '';
    },
    $scope.isSort = function (term,sort) {
    	if(sort.term == term){
    		return true;
    	}
    	return false;
    },    
    $scope.haveSelected = function(list){	
    	return  list.some(function (e) {
    		return e.selected;
    	});
    },
    $scope.isSelectedClientes,
    $scope.isSelectedLocacaoes,
    $scope.selectAllList = function(list){
    	for(var i=0;i<list.length;i++){
    		list[i].selected = true;
    	}
    	return list;   	 
    }, 
    $scope.deselectAllList = function(list){
    	for(var i=0;i<list.length;i++){
    		list[i].selected = false;
    	}
    	return list;   	 
    };


  // A cada um segundo e meio dispara uma requisição ajax para atualizar os dados...

  store.setTimer(setInterval(function () {
  	$http.get($serverUrl + "filmes?token="+ $token).then(function(req){
  		if(!arraysEqual(store.getFilmes(), req.data)){
  		store.setFilmes(req.data);
  	}
  }, function(e){
  	console.log(e);
  });

  	$http.get($serverUrl + "clientes?token="+ $token).then(function(req){
  		if(!arraysEqual(store.getClientes(), req.data)){
  			store.setClientes(req.data);
  		}
  	}, function(e){
  		console.log(e);
  	});

  },1500));


// Inicia o time


store.getTimer();



}),

filmesController = app.controller('FilmesController',function($scope,$http,$filter,store){

	$scope.isFilmesSelectedAll = false,
	$scope.hiddenFilmesAddZone = false;
	$scope.selectAllFilmes = function(list){
		if($scope.isFilmesSelectedAl){
			for(var i=0;i<list.length;i++){
				list[i].selected = false;
			}

		}else{

			for(var i=0;i<list.length;i++){
				list[i].selected = true;
			}       	
		}    
		$scope.isFilmesSelectedAl = !$scope.isFilmesSelectedAl;
		return list;  
	};
	$scope.deleteFilmes = function(list){
		store.setFilmes(list.filter(function(item){
			if(item.selected){
				vd = $http.get($serverUrl + "filme/delete/"+item.id+"?token="+ $token).then(function(req){
					if(req.data.status == "sucess"){
						return true;
					}

					return false;
					
				}, function (error){
					console.log(error);
					return false;
				});
				return vd.$$state.value;
			}
			return true;
		}));
	};
	$scope.toggleAddFilme = function () {
		$scope.hiddenFilmesAddZone = !$scope.hiddenFilmesAddZone;
	},
	$scope.addFilme = function(filme){
		if(filme != null){
			var data = $.param({
				titulo: filme.titulo,
				ano: filme.ano,
				duracao: filme.duracao ,
				preco_locacao: filme.preco_locao,
				token : $token
			});
			var config = {
				headers : {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			}
			$http.post($serverUrl + "filmes", data, config)
			.then(function (req) {
				if(req.data.id != null){
					var vx = store.getFilmes();
					vx.push(angular.copy(req.data));
					store.setFilmes(vx);
					delete tempFilme;
					$scope.toggleAddFilme();
				}
				else{
					alert(req.data.error);
				}
			},function(error){
				console.log(error);
			});
		}
	};
	$scope.deleteFilmeById = function(index,filme){ 
		$http.get($serverUrl + "filme/delete/"+filme.id+"?token="+ $token).then(function(req){
			var filmes = store.getFilmes();
			filmes.splice(index,1);
			store.setFilmes(filmes);      
		}, function(e){
			console.log(e);
		});			
	};
	
}),

clientesController = app.controller('ClientesController',function($scope,$http,$filter,store){

	$scope.isClientesSelectedAll = false,
	$scope.hiddenClientesAddZone = false;
	$scope.selectAllClientes = function(list){
		if($scope.isClientesSelectedAl){
			for(var i=0;i<list.length;i++){
				list[i].selected = false;
			}

		}else{

			for(var i=0;i<list.length;i++){
				list[i].selected = true;
			}       	
		}    
		$scope.isClientesSelectedAl = !$scope.isClientesSelectedAl;
		return list;  
	};

	$scope.deleteClientes = function(list){
		store.setClientes(list.filter(function(item){
			if(item.selected){
				vd = $http.get($serverUrl + "cliente/delete/"+item.id+"?token="+ $token).then(function(req){
					if(req.data.status == "sucess"){
						return true;
					}
					return false;					
				}, function (error){
					console.log(error);
					return false;
				});
				return vd.$$state.value;
			}
			return true;
		}));
	};

	$scope.toggleAddCliente = function () {
		$scope.hiddenClientesAddZone = !$scope.hiddenClientesAddZone;
	};
	$scope.deleteClienteById = function(index,cliente){ 
		$http.get($serverUrl + "cliente/delete/"+cliente.id+"?token="+ $token).then(function(req){
			var clientes = store.getFilmes();
			clientes.splice(index,1);
			store.setClientes(clientes);      
		}, function(e){
			console.log(e);
		});			
	};
	$scope.addCliente = function(cliente){
		if(cliente != null){
			var data = $.param({
				nome: cliente.nome,
				cpf: cliente.cpf,
				token : $token
			});
			var config = {
				headers : {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			}
			$http.post($serverUrl + "clientes", data, config)
			.then(function (req) {
				if(req.data.id != null){
					var vx = store.getClientes();
					vx.push(angular.copy(req.data));
					store.setClientes(vx);
					delete tempCliente;
					$scope.toggleAddCliente();
				}
				else{
					alert(req.data.error);
				}
			},function(error){
				console.log(error);
			});
		}
	};










}),
locacoesController = app.controller('LocacoesController',function($scope,$http,$filter){


	



});

