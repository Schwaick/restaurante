<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/angular.min.js"></script>
  <script src="js/app.js"></script>
  <script src="js/jquery-3.1.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body ng-app="app" ng-controller="controller">
  <div id="pesquisa">
    <h2>Digite a data e a hora da reserva</h2>
    <form class="form-horizontal" ng-submit="pesquisar()">
      <div class="form-group">
        <label for="data" class="col-sm-2 control-label">Data</label>
        <div class="col-sm-7">
          <input type="date" class="form-control" ng-model="data" id="data" required>
        </div>
      </div>
      <div class="form-group">
        <label for="hora" class="col-sm-2 control-label">Hora</label>
        <div class="col-sm-7">
          <input type="time" class="form-control" ng-model="hora" id="hora" required>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
          <button type="submit" class="btn" id="pesquisar">Pesquisar</button>
        </div>
      </div>
    </form>
  </div>

  <div id="planta">
    <div ng-repeat="imagem in imagens" ng-show="mostrarMesas">
      <a href="" ng-click="selecionar(imagem)" data-toggle="modal" data-target="#myModal">
        <img id="{{imagem.imagem_id}}" ng-src="img/{{imagem.imagem_source}}" />
      </a>
    </div>
  </div>

  <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div ng-if="selecionado.imagem_source.indexOf('verde')!==-1">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Fazer reserva</h4>
          </div>
          <form id="reservar" ng-submit="reservar(nome,numero,termino,prato)">
            <div class="modal-body">
              <p>Mesa: {{selecionado.id}}</p>
              <p>Descrição da mesa: {{selecionado.descricao_localizacao}}.</p>
              <p>Quantidade de cadeiras: {{selecionado.quantidade_cadeiras}}</p>
              <p>Valor da mesa: {{selecionado.valor | currency:'R$'}}</p>
              <div class="form-group">
                <label for="nome" class="control-label">Nome</label>
                <input type="text" class="form-control" id="nome" ng-model="nome" required>
              </div>
              <div class="form-group">
                <label for="numero" class="control-label">Número de pessoas</label>
                <input type="number" class="form-control" id="numero" ng-model="numero" min="1" max="{{selecionado.quantidade_cadeiras}}" required>
              </div>
              <div class="form-group">
                <label for="prato" class="control-label">Prato</label>
                <select class="form-control" ng-model="prato">
                  <option value="macarronada">Macarronada</option>
                  <option value="arrozfeijao">Arroz e feijão</option>
                  <option value="lasanha">Lasanha</option>
                </select>
              </div>
              <div class="form-group">
                <label for="data-reserva" class="control-label">Data da reserva</label>
                <input type="date" class="form-control" id="data-reserva" ng-value="data|date:'yyyy-MM-dd'" readonly>
                <p class="help-block">Se quiser alterar a data, feche essa janela e pesquise pela data novamente.</p>
              </div>
              <div class="form-group">
                <label for="hora-reserva" class="control-label">Hora da reserva</label>
                <input type="time" class="form-control" id="hora-reserva" ng-value="hora|date:'HH:mm'" readonly>
                <p class="help-block">Se quiser alterar a hora, feche essa janela e pesquise pela hora novamente.</p>
              </div>
              <div class="form-group">
                <label for="termino" class="control-label">Término da reserva</label>
                <input type="time" class="form-control" id="termino" ng-model="termino" min="{{hora|date:'HH:mm'}}" max="{{max|date:'HH:mm'}}" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Reservar</button>
              <button type="reset" class="btn btn-danger">Limpar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
          </form>
        </div>
        <div ng-if="selecionado.imagem_source.indexOf('vermelho')!==-1">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reservado</h4>
          </div>
          <div class="modal-body">
            <p>Mesa: {{selecionado.id}}</p>
            <p>Descrição da mesa: {{selecionado.descricao_localizacao}}.</p>
            <p>Quantidade de cadeiras: {{selecionado.quantidade_cadeiras}}</p>
            <p>Valor da mesa: {{selecionado.valor | currency:'R$'}}</p>
            <p>Nome: {{reserva.nome_pessoa}}</p>
            <p>Número de pessoas: {{reserva.numero_pessoas}}</p>
            <p>Prato: {{reserva.prato}}</p>
            <p>Reserva de {{reserva.hora_reserva|date:'HH:mm'}} às {{reserva.termino_reserva|date:'HH:mm'}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>