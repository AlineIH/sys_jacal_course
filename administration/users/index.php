<?php require_once('../../resources/menuManager/header.php'); ?>
<div id="app" class="pt-3">
  <div class="row">
    <div class="col-12 d-flex justify-content-end">
      <button @click="showModal('mdlNew')" class="btn btn-success">Nuevo</button>
    </div>
  </div>
  <table class="table">
    <thead>
      <th>Usuario</th>
      <th>Nombre de usuario</th>
    </thead>
    <tbody v-for="({USE_NAME, USE_USER_NAME}, index) in globalData">
      <tr>
        <td>{{ USE_NAME }}</td>
        <td>{{ USE_USER_NAME }}</td>
      </tr>
    </tbody>
  </table>


  <!-- Modal -->
  <div class="modal fade" id="mdlNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Registro de usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div v-if="isProcess" class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div class="alert alert-success" role="alert" v-if="isSuccess">
          Usuario registrado con éxito
        </div>
        <div class="alert alert-warning" role="alert" v-if="isFail">
          Usuario no registrado
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" v-model="txtName">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="saveNew">Guardar</button>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="index.js"></script>
<?php require_once('../../resources/menuManager/footer.php'); ?>