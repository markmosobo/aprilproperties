<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Compose SMS</h5>
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="btn btn-sm btn-primary rounded-pill"
                  style="background-color: darkgreen; border-color: darkgreen;"
                  @click="toTenants"
                >
                  To Tenant(s)
                </a>

             <div class="row m-auto p-auto justify-content- g-3 needs-validation" novalidate="" autocomplete="off">
                <div class="row  mb-3"></div>
 
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <input
                      type="hidden"
                      id="user_id"
                      name="user_id"
                      value="1"
                      class="form-control"
                   />
                   <div class="col-sm-12">
                      <label for="inputPassword" class="form-label">Tenant*</label>
                      <div class="col-sm-10">
                          <div class="multiselect-searchable">
                            <input type="text" v-model="searchTenantQuery" placeholder="Search Tenants..." class="search-input" />
                            <div class="row mb-3"></div>                            
                            <select v-model="form.selectedTenants" multiple class="form-select" id="tenant">
                              <option value="" disabled>Select Tenant(s)</option>
                              <option v-for="tenant in filteredTenants" :key="tenant.id" :value="tenant.phone_number">
                                {{ tenant.phone_number }} - {{ tenant.first_name }} {{ tenant.last_name }} - {{ tenant.property.name }} - {{ tenant.unit.unit_number }}
                              </option>
                            </select>
                            
                          </div>
                        <div class="invalid-feedback" v-if="!selectedTenants">Please select tenant!</div>
                      </div>
                   </div>
                  <div v-if="form.selectedTenants.length > 0" class="form-group row mt-3">
                    <div class="col-sm-12">
                      <button class="btn btn-sm btn-primary" style="background-color: green; border-color: green;" type="button" @click="toggleSelectedTenants">
                        {{ showSelectedTenants ? 'Hide' : 'Show' }} Selected Tenants ({{ form.selectedTenants.length }})
                      </button>
                      <div v-show="showSelectedTenants" class="selected-tenants mt-2">
                        <ul class="list-group">
                          <li v-for="(tenant, index) in form.selectedTenants" :key="index" class="list-group-item d-flex justify-content-between align-items-center">
                            {{ tenant }}
                            <button class="btn btn-danger btn-sm" @click="removeTenant(index)">Remove</button>
                          </li>
                        </ul>
                        <button class="btn btn-danger btn-sm mt-2" @click="clearAllTenants">Clear All</button>
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <input
                      type="hidden"
                      id="user_id"
                      name="user_id"
                      value="1"
                      class="form-control"
                   />
                   <div class="col-sm-12">
                      <label for="inputPassword" class="form-label">Message*</label>
                      <div class="col-sm-10">
                        <textarea v-model="form.message" name="message" id="message" class="form-control" style="height: 100px"></textarea>
                        <div class="invalid-feedback">Please compose message!</div>
                      </div>
                   </div>
 
                </div>
             </div>
             <!--  button -->
             <div class="col-lg-12 felx mt-4 row">
                <div class="col-sm-6 col-lg-6">
                    <!-- <button @click.prevent="prev()" class="btn btn-dark">Previous</button> -->
                </div>
                <div class="col-sm-6 col-lg-6 text-end">
                    <button type="submit" style="background-color: darkgreen; border-color: darkgreen;" @click.prevent="sendSms()" class="btn btn-sm btn-primary rounded-pill">Send</button>
                </div>
            </div>
          </fieldset>
 
          </form>
 
 
          <!-- End General Form Elements -->
       </div>
    </div>
    </TheMaster>
    
 
 
    <!--  actual form -->
 </template>
    
 <script>
 import TheMaster from "@/components/dashboard/TheMaster.vue";

 import axios from "axios";
 import Swal from 'sweetalert2';

 
 const toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000
 });
 
 window.toast = toast;
 
 export default {
    components : {
       TheMaster,
    },
    data () {
       return {
         paid: '',
         message: '',
         total: '',
         form:
         {
           selectedTenants: [],
           message: ''
         },
          step: 1, 
          propunits: [],
          tenants: [],
          depositRent: [],
          unitNumber: '',
          tenantId: null, // Initialize tenantId
          user: [],
          deposit: '',
          monthly_rent: '',
          refNo: '',
          propertyName: '',
          searchTenantQuery: '',
          showTenantDiv: true, // Add this data property
          showSelectedTenants: false,


       }   
    },
    methods: {
      prev() {
          this.step--;
       },
       next() {
          // this.step++;
          this.submit();          
       },
      toTenants() {
          this.showTenantDiv = true; // Hide the div when "To Tenants" is clicked
          this.showLandlordDiv = false; // Hide the div when "To Tenants" is clicked
      },
       toggleSelectedTenants() {
        this.showSelectedTenants = !this.showSelectedTenants;
      },
      removeTenant(index) {
        this.form.selectedTenants.splice(index, 1);
      },
      clearAllTenants() {
        this.form.selectedTenants = [];
      },
      formatMonth(value){
          if(value){
            return moment(String(value)).format('MMM YYYY');
          }
      },      
       //ID upload
       onChangePhoto(e) {
         console.log('loadings');
         let file = e.target.files[0];
         console.log(file)
         let reader = new FileReader();
         reader.onloadend = (file) => {
            // console.log('RESULT', reader.result)
            this.form.image = reader.result;
         }
         reader.readAsDataURL(file);
       },
       getUnits() {
             axios.get('/api/pmsvacantunits/'+this.form.pms_property_id).then((response) => {
     
             this.propunits = response.data.units;
             console.log("props", response)
    
             });

         // try {
         //   //const propunits = this.units.find(unit => unit.pms_property_id === this.form.pms_property_id);
         //   this.propunits = this.units.filter(item => item.pms_property_id === this.form.pms_property_id && item.status === 0);

         //   console.log("amoit", this.propunits)
         // } catch (error) {
         //   console.error(error);
         // }
       }, 
       getUnitInfo()
       {
            axios.get('/api/pmsunit/'+this.form.pms_unit_id).then((response) => {
     
             this.unitinfo = response.data.unit[0];
               this.deposit = parseInt(this.unitinfo.deposit);
               this.monthly_rent = parseInt(this.unitinfo.monthly_rent);
               this.garbage_fee = parseInt(this.unitinfo.garbage_fee);
               this.security_fee = parseInt(this.unitinfo.security_fee);
               this.water_deposit = parseInt(this.unitinfo.water_deposit);
               this.electricity_deposit = parseInt(this.unitinfo.electricity_deposit);
             this.depositRent = this.deposit + this.monthly_rent + this.garbage_fee + this.security_fee + this.water_deposit + this.electricity_deposit;
             this.unitNumber = this.unitinfo.unit_number;
             console.log("unitinfo", response)
    
             });
       },
       async loginUwazii() {
          try {
            const data = JSON.stringify({
              "username": "April_Properties",
              "password": "Mosobo*123#"
            });

            const config = {
              method: 'post',
              maxBodyLength: Infinity,
              url: 'https://restapi.uwaziimobile.com/v1/authorize',
              headers: {
                'Content-Type': 'application/json'
              },
              data: data
            };

            const response = await axios(config);
            this.authorizationCode = response.data.data.authorization_code; // Save authorizationCode into this.authorizationCode
            console.log(this.authorizationCode);
          } catch (error) {
            console.log(error);
          }
        },

        async getAccessToken() {
          try {
            const data = JSON.stringify({
              "authorization_code": this.authorizationCode
            });

            const config = {
              method: 'post',
              maxBodyLength: Infinity,
              url: 'https://restapi.uwaziimobile.com/v1/accesstoken',
              headers: {
                'Content-Type': 'application/json'
              },
              data: data
            };

            const response = await axios(config);
            this.accessToken = response.data.data.access_token; // Save accessToken into this.accessToken
            console.log(this.accessToken);
          } catch (error) {
            console.log(error);
          }
        },

        async sendSms() {
          if (this.validateForm()) {  
          console.log(this.form);              
            await this.loginUwazii();
            await this.getAccessToken();

            // Uncomment and use this block to send an SMS once the token is obtained.
            // Fetch tenant data and wait for it to complete
              // await this.getTenant(tenantId);

              // Ensure tenant details are available before creating the payload
              const payload = {
                  'token': this.accessToken,
                  'message': this.form.message,  // Use the dueAmount from statement
                  'number': this.formatPhoneNumber(this.form.selectedTenants.toString()) // Format the phone number
              };

              axios.post('/api/sendtenantsms', payload)
              .then((response) => {
                  console.log("sms status", payload);
              })
              .catch((error) => {
                  console.error("Error sending sms:", error);
              });
          }
        },
        formatPhoneNumber(number) {
            // Ensure number is a string
            number = number.toString();
            
            // Clean the phone number and ensure it has the 254 prefix
            if (number.startsWith('0')) {
                // Remove the leading zero and add the 254 prefix
                number = '254' + number.substring(1);
            } else if (!number.startsWith('254')) {
                // If the number is not already prefixed with 254, add it
                number = '254' + number;
            }
            return number;
        },
        getFormattedDate() {
          const today = new Date();
          const year = today.getFullYear();
          const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
          const day = String(today.getDate()).padStart(2, '0');

          return `${year}-${month}-${day}`;
        },     
       loadLists() {
          axios.get('api/lists').then((response) => {
          this.units = response.data.lists.units;
          this.properties = response.data.lists.pmsproperties;
          this.landlords = response.data.lists.landlords;
          this.tenants = response.data.lists.pmstenants;
          console.log(response)
 
          });
       },
       validateForm() {
          let isValid = true;
          if (!this.form.selectedTenants) {
              isValid = false;
              document.getElementById('tenant').classList.add('is-invalid');
          } else {
              document.getElementById('tenant').classList.remove('is-invalid');
          }
          if (!this.form.message) {
              isValid = false;
              document.getElementById('message').classList.add('is-invalid');
          } else {
              document.getElementById('message').classList.remove('is-invalid');
          }

          return isValid;
       },
       submit(){
        if (this.validateForm()) {                
          let self = this;
          axios.post("api/tenants", this.form)
          .then(function (response) {
             console.log(response);
             self.tenantId = response.data.tenant.id;
             // this.tenantId = tenantid;
             console.log("tenant", self.tenantId);

             // this.step = 1;
             toast.fire(
                'Success!',
                'Tenant added!',
                'success'
             )
          })
          .catch(function (error) {
             console.log(error);
             // Swal.fire(
             //    'error!',
             //    // phone_error + id_error + pass_number,
             //    'error'
             // )
          });
          this.$router.push('/pmstenants')
        }  
 
       },
        async submitStatement() {
          try {
            const payload = {
              mpesa_code: this.form.mpesa_code,
              payment_method: this.form.payment_method,
              paid: this.form.cash,
              balance: this.payableAmount,
              total: this.depositRent,
              pms_property_id: this.form.pms_property_id,
              unit_number: this.unitNumber,
              pms_tenant_id: this.tenantId
            };

            const response = await axios.post("api/pmsstatements", payload);
            console.log(response);
            this.statement = response.data.pmsstatement;
            this.refNo = this.statement.ref_no;
            this.propertyId = this.statement.pms_property_id;
            await this.getProperty(); // Wait for getProperty to finish
            await this.getTenant();
            this.date = this.statement.created_at;
            this.details = this.statement.details;
            console.log("tenant-statement", this.propertyId);
            
            // toast.fire(
            //   'Success!',
            //   'Invoice saved!',
            //   'success'
            // );

            // Returning statement data to be used in printReceipt method
            return this.statement;
          } catch (error) {
            console.log(error);
            // Handle error if needed
            throw error; // Propagate the error
          }
        },

        async getProperty() {
          try {
            const response = await axios.get('/api/pmsproperty/' + parseInt(this.propertyId));
            console.log("propertiit", response);
            this.property = response.data.property[0];
            this.name = this.property.name;
            // Further processing of the response data if needed
          } catch (error) {
            console.error("Error fetching unit:", error);
            // Handle error if needed
          }
        },

        async getTenant() {
          try {
            const response = await axios.get('/api/pmstenant/' + parseInt(this.tenantId));
            console.log("tenant", response);
            this.tenant = response.data.tenant[0];
            this.tenant = this.tenant.first_name + " " + this.tenant.last_name;
            // Further processing of the response data if needed
          } catch (error) {
            console.error("Error fetching unit:", error);
            // Handle error if needed
          }
        },
      formatNumber(value) {
          // Check if the value is null or undefined
          if (value == null) return '';

          // Convert value to string
          let stringValue = value.toString();

          // Split the string into integer and decimal parts
          let [integerPart, decimalPart] = stringValue.split('.');

          // Add commas to the integer part
          integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

          // Add trailing zeros to the decimal part if needed
          if (decimalPart == null) decimalPart = '00';
          else if (decimalPart.length === 1) decimalPart += '0';

          // Combine integer and decimal parts with a dot
          return `${integerPart}.${decimalPart}`;
        },       
 
    },
    mounted() {
       this.loadLists();
       this.formattedDate = this.getFormattedDate();       
       this.user = JSON.parse(localStorage.getItem('user'));
    },
    computed: {
        payableAmount() {
          // if (this.paid > 0) {
          //   return this.balance - this.form.cash;
          // }
          // else
          // {
             return this.depositRent - this.form.cash; // Multiply inputValue by 2 (change this multiplier as needed)
          // }
       
        },
        showNoUnitsMessage() {
          return !this.propunits || this.propunits.length === 0;
        },
        filteredLandlords() {
             return this.landlords.filter((landlord) => {
             const searchTerm = this.searchTenantQuery.toLowerCase();
             const fullName = `${landlord.first_name} ${landlord.last_name}`.toLowerCase();
             return (
              fullName.includes(searchTerm) ||
              landlord.phone_no.includes(searchTerm)
            );
          });
        },
        filteredTenants() {
             return this.tenants.filter((tenant) => {
             const searchTerm = this.searchTenantQuery.toLowerCase();
             const fullName = `${tenant.first_name} ${tenant.last_name}`.toLowerCase();
             return (
              fullName.includes(searchTerm)
               // ||
              // tenant.phone_number.includes(searchTerm)
            );
          });
        },
    },    
 
 }
 </script>
    
 
 
 <style lang="css" scoped>
 /*Profile Pic Start*/
 .picture-container {
    position: relative;
    cursor: pointer;
    text-align: center;
 }
 
 .picture {
    width: 106px;
    height: 106px;
    background-color: #99999;
    border: 4px solid #CCCCCC;
    color: #FFFFFF;
    border-radius: 50%;
    margin: 0px auto;
    overflow: hidden;
    transition: all 0.2s;
    -webkit-transition: all 0.2s;
 }
 
 .picture:hover {
    border-color: #2ca8ff;
 }
 
 .content.ct-wizard-green .picture:hover {
    border-color: #05ae0e;
 }
 
 .content.ct-wizard-blue .picture:hover {
    border-color: #3472f7;
 }
 
 .content.ct-wizard-orange .picture:hover {
    border-color: #ff9500;
 }
 
 .content.ct-wizard-red .picture:hover {
    border-color: #ff3b30;
 }
 
 .picture input[type="file"] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0 !important;
    position: absolute;
    top: 0;
    width: 100%;
 }
 
 .picture-src {
    width: 100%;
 
 }
.multiselect-searchable {
  position: relative; /* Necessary for proper positioning of the search input */
}

.search-input {
  width: 100%;
  padding: 5px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
</style>