<?php
  include '../../controller/paiements.php';
  require_once '../../layout/header.php'; 
  require_once '../../layout/sidebar.php';
  require_once '../../layout/navbar.php';
?>
  <style type="text/css">
  main {
    margin-left: 50px; 
  }
</style>
<div class="content"> <!--Mbola tsy mandeha ilay boutton enregistrer sy annuler amty fa copie coller config io-->
  <div class="container-fluid">
    <div class="container">
      <form method="post">
        <?= $data_param ? '<input type="text" name="id" value="'.$data_param->param_id.'" hidden="true">' :'' ?>
        <div class="row">
          <div class="col-md-2 flex content-space">
            <button type="submit" name="submit_param" class="btn btn-danger"><?= $data_param ? 'Modifier' :'Enregister'?></button>&nbsp;  <span>ou</span>&nbsp;  
            <a href="<?=$base_url?>/pages/parametrages">Annuler</a>
          </div>
        </div>
        <br>
        <main>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label ncnomfor="nc">NC : </label>
                </div>
                <div class="col-sm-9">
                  <input type="text" ncnomname="nc" value="<?= $data_param ? $data_param->param_table :'' ?>" id="nc" class="form-control form-control-perso" placeholder="NC">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="nom">Nom :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="nom" value="<?= $data_param ? $data_param->param_sigle :'' ?>" id="nom" class="form-control form-control-perso" placeholder="Nom">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="prenom">Prénom :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="prenom" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="prenom" class="form-control form-control-perso" placeholder="Prénom">
                </div>
              </div>
            </div>
           </div>
      
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="numero">Numéro :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="numero" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="numero" class="form-control form-control-perso" placeholder="Numéro">
                </div>
              </div>
            </div>
           </div>

           <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="matricule">Numéro Matricule :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="matricule" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="matricule" class="form-control form-control-perso" placeholder="Numéro Matricule">
                </div>
              </div>
            </div>
          </div>

        <div class="row form-group">
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
    </div>

  <div class="row form-group">
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
    </div>

      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Catégorie classe :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_classe" name="type_classe"> 
                    <option>Aucun</option>
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
     </div>

    <div class="row form-group">
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
    </div>

          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="matricule">Date :</label>
                </div>
                <div class="col-sm-9">
                  <input type="date" name="date" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="date" class="form-control form-control-perso">
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Type de paiement :</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="type_paiement" name="type_paiement"> 
                    <option>BACC</option>
                    <option>BEPC</option>
                    <option>CARNET</option>
                    <option>CARTE</option>
                    <option>CERTIFICAT</option>
                    <option>CHANGEMENT DE CLASSE</option>
                    <option>DROIT</option>
                    <option>ECOLAGE</option>
                    <option>EXAMEN BLANC</option>
                    <option>IDENTITE</option>
                    <option>RELEVER DE NOTE</option>
                    <option>SUPPL MATIERE</option>
                    <option>TEE-SHIRT</option>
                    <option>TRANSFERT</option>  
              </select>
            </div>
          </div>
        </div>
     </div>

          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="numero">Numéro Reçu:</label><!--ito ilay atao miseo automatiques-->
                </div>                                     <!--atao miseo koa ny dernier numero napidirina-->
                <div class="col-sm-9">
                  <input type="text" name="recu" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="recu" class="form-control form-control-perso" placeholder="Numéro Reçu">
                </div>
              </div>
            </div>
           </div>

          <div class="row form-group">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <label for="numero">Montant Payé :</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="montant" value="<?= $data_param ? $data_param->param_valeur :'' ?>" id="montant" class="form-control form-control-perso" placeholder="Montant Payé">
                </div>
              </div>
            </div>
           </div>

      <div class="row form-group">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-3">
              <label for="classe">Mode de paiement:</label>
            </div>
            <div class="col-sm-9">
              <select class="form-control" id="mode_paiement" name="mode_paiement"> 
                    <option>Normal</option>
                    <option>Réduit</option>
                       
              </select>
            </div>
          </div>
        </div>
     </div>

          
        </main>
      </form>
    </div>
  </div>
</div>
<?php require_once '../../layout/footer.php'; ?>

<?php require_once '../../layout/footer.php'; ?>