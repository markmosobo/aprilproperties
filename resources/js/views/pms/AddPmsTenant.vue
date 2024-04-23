<template>
    <TheMaster>
        <div class="card px-2">
       <div class="card-body">
          <!-- General Form Elements -->
          <form @submit.prevent="">
          <fieldset v-if="step == 1">
             <h5 class="card-title text-center">Personal Information</h5>
 
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
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">First Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="First Name"
                            id="title"
                            name="title"
                            v-model="form.first_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter first name!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Last Name*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Last Name"
                            id="title"
                            name="title"
                            v-model="form.last_name"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter last name!</div>
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
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">ID Number*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="ID Number"
                            id="title"
                            name="title"
                            v-model="form.id_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter ID number!</div>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <label for="inputPassword" class="form-label">Phone Number*</label>
                      <div class="col-sm-10">
                        <input
                            type="text"
                            placeholder="Phone Number"
                            id="title"
                            name="title"
                            v-model="form.phone_number"
                            class="form-control"
                            required=""
                        />
                        <div class="invalid-feedback">Please enter phone number!</div>
                      </div>
                   </div>
 
                </div>
                <div class="row mb-3"></div>
                <div class="form-group row">
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Property*</label
                      >
                      <div class="col-sm-10">
                         <select @change="getUnits" name="landlord" v-model="form.pms_property_id" class="form-select" id="">
                            <option value="0" selected disabled>Select Property</option>
                            <option v-for="property in properties" :value="property.id"
                            :selected="property.id == form.pms_property_id" :key="property.id">{{ property.name}} </option>
 
                         </select>
 
                         <div class="invalid-feedback">Please select a property!</div>
                      </div>
                   </div>  
                   <div class="col-sm-6">
                      <label for="validationCustom04" class="form-label"
                      >Unit*</label
                      >
                      <div class="col-sm-10">
                         <select @change="getUnitInfo" :disabled="!form.pms_property_id" name="unit" v-model="form.pms_unit_id" class="form-select" id="">
                            <option value="0" selected disabled>Select Unit</option>
                            <option v-for="unit in propunits" :value="unit.id"
                            :selected="unit.id == form.unit_id" :key="unit.id">{{ unit.unit_number}}</option>
 
                         </select>
 
                         <div class="invalid-feedback">Please select a unit!</div>
                         <div v-if="showNoUnitsMessage" class="text-danger">No units available for selected property.</div>


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
                    <button type="submit" style="background-color: darkgreen; border-color: darkgreen;" @click.prevent="next()" class="btn btn-sm btn-primary rounded-pill">Proceed to Invoice</button>
                </div>
            </div>
          </fieldset>

          <fieldset v-if="step == 2">
                   <h5 class="card-title">Settle Invoice</h5>
                  <div class="row">
                    <div class="col-lg-12 col-md-4 label ">Rent & Deposit:<strong>KES {{formatNumber(depositRent)}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.first_name}} {{form.last_name}}</div> -->
                  </div>                
                    <form
                    class="row g-3 needs-validation"
                    novalidate=""
                    method="post"
                    autocomplete="off"
                    >
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
                        <label for="validationCustom04" class="form-label"
                          >Please select payment method:</label
                        >
                        <div class="col-sm-10">
                            <select name="category" v-model="form.payment_method" class="form-select" id="">
                                <option value="0" disabled>Select Payment</option>
                                <option value="Mpesa" selected>MPESA (Till Number)</option>
                                <option value="Cash">CASH</option>
                                <option value="Bank">BANK</option>

                            </select>
                          <div class="invalid-feedback">Please enter flight number!</div>
                        </div>
                      </div>
                    </div>
             
                    <div class="row mb-3"></div>
                    <div v-if="form.payment_method === 'Mpesa'" class="form-group row">
                      <div class="col-sm-12">
                        <label for="inputPassword" class="form-label">Please provide MPESA code</label>
                        <div class="col-sm-10">
                          <input
                            type="decimal"
                            placeholder="Transaction Code"
                            v-model="form.mpesa_code"
                            id="mpesa_code"
                            name="mpesa_code"
                            class="form-control"
                            required=""
                          />
                          <div class="invalid-feedback">Please enter address!</div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3"></div>

                    <div class="col-md-6">
                    <label for="inputEmail5" class="form-label">Amount Paid</label>
                    <input type="number" v-model="form.cash" class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">Balance</label><br>
                    
                     <h6>{{formatNumber(payableAmount)}}</h6>
                    </div>        
                    <div class="row mb-3"></div>
                    <div class="col-lg-12 felx mt-4 row">
                        <div class="col-sm-6 col-lg-6">
                        <button @click.prevent="prev()" class="btn btn-sm btn-dark rounded-pill">Previous</button>
                        </div>
                        <div class="col-sm-6 col-lg-6 text-end">
                        <button @click.prevent="printReceipt()" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-sm rounded-pill btn-primary">Print Receipt</button>
                        </div>
                    </div>
                  </form>
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
         balance: '',
         total: '',
         tenantId: null,
         form:
         {
           payment_method: '',
           cash: '',
           mpesa_code: '',
           balance: ''
         },
          step: 1, 
          propunits: [],
          properties: [],
          depositRent: [],
          unitNumber: '',
          tenantId: null, // Initialize tenantId
          user: [],
          deposit: '',
          monthly_rent: '',
          refNo: '',
          propertyName: ''

       }   
    },
    methods: {
      prev() {
          this.step--;
       },
       next() {
          this.step++;
          this.submit();          
       },
      buildReceiptContent(refNo) {
        // Determine whether to include the row
        const showGarbageFeeRow = this.garbage_fee !== 0;
        const showSecurityFeeRow = this.security_fee !== 0;
        const showElectricityDepositRow = this.electricity_deposit !== 0;
        const showWaterDepositRow = this.water_deposit !== 0;
        // Build the HTML content for the receipt
        const receiptHTML = `
          <!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Receipt Of Payment</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      margin: 0;
                      padding: 0;
                      background-color: #f5f5f5;
                      color: #333;
                  }
                  .container {
                      max-width: 600px;
                      margin: 20px auto;
                      padding: 20px;
                      background-color: #fff;
                      border: 2px solid #ccc;
                      border-radius: 10px;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }
                  .header {
                      text-align: center;
                      margin-bottom: 20px;
                  }
                  .header h1 {
                      margin: 10px 0;
                      color: #333;
                  }
                  .info {
                      margin-bottom: 20px;
                  }
                  .info p {
                      margin: 5px 0;
                      color: #555;
                  }
                  .table {
                      width: 100%;
                      border-collapse: collapse;
                      margin-bottom: 20px;
                  }
                  .table th, .table td {
                      padding: 8px;
                      border-bottom: 1px solid #ccc;
                      text-align: left;
                  }
                  .table th {
                      background-color: #f2f2f2;
                      color: #333;
                  }
                  .table td {
                      color: #666;
                  }
                  .footer {
                      text-align: center;
                      margin-top: 20px;
                      color: #777;
                  }
              </style>
          </head>
          <body>
          <div class="container">
              <div class="header">
                  <h1>April Properties</h1>
                  <p>Kakamega-Webuye Rd, ACK Building</p>
                  <p>Phone: (0720) 020-401 | Email: propertapril@gmail.com</p>
              </div>
              <div class="info">
                  <p><strong>Invoice Number:</strong> ${this.refNo}</p>
                  <p><strong>Receipt Date:</strong> ${new Date().toLocaleString()}</p>
                  <p><strong>For:</strong> ${this.details}</p>
                  <p><strong>Payment Mode:</strong> ${this.form.payment_method}</p>
                  <p><strong>Property:</strong> ${this.name}</p>
                  <p><strong>Tenant:</strong> ${this.tenant}</p>
              </div>
              <table class="table">
                  <thead>
                  <tr>
                      <th>Description</th>
                      <th>Amount</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td>Rent Deposit</td>
                      <td>KES ${this.formatNumber(this.deposit)}</td>
                  </tr>
                  <tr>
                      <td>Monthly Rent</td>
                      <td>KES ${this.formatNumber(this.monthly_rent)}</td>
                  </tr>
                  ${showGarbageFeeRow ? `
                  <tr>
                      <td>Garbage Collection Fee</td>
                      <td>KES ${this.formatNumber(this.garbage_fee)}</td>
                  </tr>
                  ` : ''}
                  ${showSecurityFeeRow ? `
                  <tr>
                      <td>Security Fee</td>
                      <td>KES ${this.formatNumber(this.security_fee)}</td>
                  </tr>
                  ` : ''}
                  ${showElectricityDepositRow ? `
                  <tr>
                      <td>Electricity Deposit</td>
                      <td>KES ${this.formatNumber(this.electricity_deposit)}</td>
                  </tr>
                  ` : ''}
                  ${showWaterDepositRow ? `
                  <tr>
                      <td>Water Deposit</td>
                      <td>KES ${this.formatNumber(this.water_deposit)}</td>
                  </tr>
                  ` : ''}
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>Total Amount Due:</th>
                      <td>KES ${this.formatNumber(this.depositRent)}</td>
                  </tr>
                  <tr>
                      <th>Amount Paid:</th>
                      <td>KES ${this.formatNumber(this.form.cash)}</td>
                  </tr>
                  <tr>
                      <th>Balance:</th>
                      <td>KES ${this.formatNumber(this.payableAmount)}</td>
                  </tr>
                  </tfoot>
              </table>
              <div class="footer">
                  <p>You were served by ${this.user.first_name} ${this.user.last_name}. Thank you for your payment.</p>
                  <p>This receipt acknowledges the payment received for the above property management services.</p>
              </div>
          </div>
          </body>
          </html>


        `;

        return receiptHTML;
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
       loadLists() {
          axios.get('api/lists').then((response) => {
          this.blogcategories = response.data.lists.blogcategories;
          this.units = response.data.lists.units;
          this.properties = response.data.lists.pmsproperties;
 
          });
       },
       submit(){
          let self = this;
          axios.post("api/tenants", this.form)
          .then(function (response) {
             console.log(response);
             self.tenantId = response.data.tenant.id;
             // this.tenantId = tenantid;
             console.log("tenant", self.tenantId);

             // this.step = 1;
             // toast.fire(
             //    'Success!',
             //    'Tenant added!',
             //    'success'
             // )
          })
          .catch(function (error) {
             console.log(error);
             // Swal.fire(
             //    'error!',
             //    // phone_error + id_error + pass_number,
             //    'error'
             // )
          });
          // this.$router.push('/pmstenants')
 
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
 
      async printReceipt() {
        try {
          // Call submitStatement() method
          const statement = await this.submitStatement();

          // Navigate to the desired route after successful submission
          this.$router.push('/pmstenants');

          // Open a new window for printing
          const printWindow = window.open("", "_blank");

          // Build the content for printing
          const receiptContent = this.buildReceiptContent(statement);

          // Write the content to the new window
          printWindow.document.write(receiptContent);

          // Close the document stream
          printWindow.document.close();

          // Trigger the print dialog
          printWindow.print();
          toast.fire(
              'Success!',
              'Invoice saved!',
              'success'
            );
        } catch (error) {
          // Handle any errors that occurred during submission or printing
          console.error("Error submitting statement or printing receipt:", error);
          // For example, display an error message to the user
          // this.errorMessage = "Failed to submit statement or print receipt. Please try again.";
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
        }
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
 
 }</style>