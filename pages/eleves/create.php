<?php
  include '../../controller/eleves.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
<div class="content">
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-danger">Enregister</button>
        </div>
      </div>
      <br>
      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="nom">Nom : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="nom" name="nom" class="form-control form-control-perso" placeholder="Nom">
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="prenom">Prénom : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="prenom" class="form-control form-control-perso" placeholder="Prénom">
            </div>
          </div>
        </div>
      </div>

      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="matricule">Numéro Matriculle : </label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="matricule" class="form-control form-control-perso" placeholder="Numéro Matriculle">
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Classe: </label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="classe" name="classe"> 
                    <option>3ème</option>
                    <option>Terminal</option>
                    <option>Universitaire</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="numero">Numéro :</label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="numero" class="form-control form-control-perso" placeholder="Numéro">
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Mention </label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="mention" name="mention"> 
                    <option></option>
                    <option>Option A</option>
                    <option>Option B</option>
                    <option>BACC A</option>
                    <option>BACC C  </option>
                    <option>BACC D </option>
                    <option>BACC TECHNIQUE </option>
                    <option>GESTION</option>
                    <option>MADAGASCAR BUSINESS SCHOOL</option>
                    <option>SCIENCES ECONOMIQUES & ETUDE DU DEVELOPPEMENT</option>
                    <option>DROIT & SCIENCE POLITIQUE</option>
                    <option>COMMUNICATION</option>
                    <option>SCIENCES DE LA SANTE</option>
                    <option>INFORMATIQUES & ELECTRONIQUES</option>
              </select>
            </div>
          </div>
        </div>


        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="date_inscription">Date d'inscription:</label>
            </div>
            <div class="col-sm-9">
              <input type="date" id="date_inscription" class="form-control form-control-perso" placeholder="date_inscription">
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Catégorie classe :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_classe" name="type_classe"> 
                    <option></option>
                    <option>AM</option>
                    <option>SS</option>
                    <option>TMS</option>
                    <option>SS+TMS</option>
                    <option>AM+SS</option>
                    <option>AM+TMS</option>
                    <option>AM+SS+TMS</option> 
                    <option>L1</option>
                    <option>L2</option>
                    <option>L3</option>
                    <option>M1</option>
                    <option>M2</option>   
              </select>
            </div>
          </div>
        </div>
            
          <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="date_inscription">Date de naissance:</label>
            </div>
            <div class="col-sm-9">
              <input type="date" id="date_inscription" class="form-control form-control-perso" placeholder="date_inscription">
            </div>
          </div>
        </div>
                <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Catégorie classe 2 :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_classe" name="type_classe"> 
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
              </select>
            </div>
          </div>
        </div>

          <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="date_inscription">Lieu de naissance:</label>
            </div>
            <div class="col-sm-9">
              <input type="text" id="date_inscription" class="form-control form-control-perso" placeholder="Lieu de naissance">
            </div>
          </div>
        </div>
   </div>
   </div>
  </div>
 </div>
</div>
<?php require_once '../../layout/footer.php'; ?>