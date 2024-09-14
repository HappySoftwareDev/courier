<?php include_once('common/header.php') ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	<!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
          	<?php if ($errors): ?>
          		<ul>
          		<?php foreach ($errors as $error) : ?>
			        <li class="text-danger"><?= esc($error) ?></li>
			    <?php endforeach ?>
			    </ul>
          	<?php endif ?>
            <h3 class="card-title">Profile Settings</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            	<form method="post" action="<?=base_url()?>/profile">
            <div class="row">
              	<div class="col-md-6">
	              	<div class="form-group">
	                  <label>Name*</label>
	                  <input type="text" class="form-control" name="business_name" id="business_name" style="width: 100%;" required value="<?=$user['business_name']?>">
              		</div>
          		</div>
              	<div class="col-md-6">
	              	<div class="form-group">
	                  <label>Email*</label>
	                  <input type="email" readonly class="form-control" name="business_email" id="business_email" style="width: 100%;" required value="<?=$user['business_email']?>">
              		</div>
          		</div>
              	<div class="col-md-6">
	              	<div class="form-group">
	                  <label>Phone*</label>
	                  <input type="text" class="form-control" name="phone" id="phone" style="width: 100%;" required value="<?=$user['business_phone']?>">
              		</div>
          		</div>
              	<!-- <div class="col-md-6">
	              	<div class="form-group">
	                  <label>Contact Person*</label>
	                  <input type="text" class="form-control" name="contact_person" id="contact_person" style="width: 100%;" required value="<?=$user['contact_person']?>">
              		</div>
          		</div> -->
              	<div class="col-md-6">
	              	<div class="form-group">
	                  <label>address*</label>
	                  <input id="autocomplete" class="form-control input-block-level" placeholder="Enter your address" type="text" name="address" onFocus="geolocate()"  style="width: 100%;" required value="<?=$user['address']?>">
	                  <!-- <input type="text" class="form-control" name="contact_person" id="contact_person" style="width: 100%;"> -->
              		</div>
          		</div>
              	<div class="col-md-12">
	              	<div class="form-group text-right">
	                  <!-- <label>Business adddress</label> -->
	                  <input class="btn btn-info" type="submit" name="submit">
	                  <!-- <input type="text" class="form-control" name="contact_person" id="contact_person" style="width: 100%;"> -->
              		</div>
          		</div>
              
              <!-- /.col -->
            </div>
              </form>
            <!-- /.row -->

          </div>
          <!-- /.card-body -->
          
        </div>
        <!-- /.card -->
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once('common/footer.php'); ?>
 <!-- Page script -->
<script>
  // auto complete
  var placeSearch, autocomplete, drop_address;

      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_3: 'short_name',
        country: 'long_name',
        componentRestrictions: GeocoderComponentRestrictions,
        postal_code: 'short_name'
      };
        var op = {componentRestrictions: {country: "zw"}};
        function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),
            {types: ['establishment' | 'address'], componentRestrictions: {country: "zw"}
            });
		/*drop_address = new google.maps.places.Autocomplete(
            (document.getElementById('drop_address')),
            {types: ['establishment' | 'address'],componentRestrictions: {country: "zw"}
            });*/
        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
        // drop_address.addListener('place_changed', fillInAddress);
      }
	  

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
		// var place = drop_address.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }
  function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAASD--ei5pvGlTxWLBswb4z4q_4J2vQS4&sensor=false&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
