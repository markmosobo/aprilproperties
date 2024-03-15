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
                    <button type="submit" @click.prevent="next()" class="btn btn-sm btn-primary rounded-pill">Proceed to Invoice</button>
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
                                <option value="MPESA" selected>MPESA (Till Number)</option>
                                <option value="CASH">CASH</option>
                                <option value="BANK">BANK</option>

                            </select>
                          <div class="invalid-feedback">Please enter flight number!</div>
                        </div>
                      </div>
                    </div>
             
                    <div class="row mb-3"></div>
                    <div v-if="form.payment_method === 'MPESA'" class="form-group row">
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
                        <button @click.prevent="printReceipt()" class="btn btn-sm rounded-pill btn-primary">Print Receipt</button>
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
      printReceipt() {
        this.submitStatement();
        this.$router.push('/pmstenants')

        // Open a new window for printing
        const printWindow = window.open("", "_blank");

        // Build the content for printing
        const receiptContent = this.buildReceiptContent();

        // Write the content to the new window
        printWindow.document.write(receiptContent);

        // Close the document stream
        printWindow.document.close();

        // Trigger the print dialog
        printWindow.print();
      },

      buildReceiptContent() {
        // Build the HTML content for the receipt
        const receiptHTML = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>INGO PROPERTIES</title>
          <style>
            body {
              font-family: monospace;
              font-size: 12px;
              margin: 0;
            }
            table, th, td {
              border-collapse: collapse;
            }
            th, td {
              padding: 5px;
              text-align: left;
            }
            .header {
              text-align: center;
            }
            .footer {
              text-align: right;
            }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>INGO PROPERTIES</h1>
            <p>P.O. BOX 1716-50100 KAKAMEGA Opp. Kenya Power Rd.</p>
            <p>Mob: 0722 844 910</p>
          </div>
          <div>
            <p>VAT: Barware - CHED</p>
            <p>WAT NO. 0161493R</p>
            <p>PIN: A0146635900</p>
            <p>Tel: 0769 08207</p>
          </div>
          <div class="header">
            <h3>FISCAL RECEIPT</h3>
            <h3>ORIGINAL</h3>
          </div>
          <table>
            <tr>
              <th>QTY</th>
              <th>Partic</th>
              <th>Invoice Nr:</th>
            </tr>
            <tr v-for="(item) in cart" :key="productId">
              <td>0001</td>
              <td>Operator 01</td>
              <td>000000000001196</td>
            </tr>
            <tr>
              <td>A</td>
              <td>00001 Art. 00001</td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td>Sum</td>
              <td>1.000 pcs X 40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>700 7000</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>40500.00 A</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>1350 13500</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL A-16.00%</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>TOTAL TAX A</td>
              <td>5586.21</td>
            </tr>
            <tr>
              <td></td>
              <td>TUTAL TAX</td>
              <td>5586.21</td>
            </tr>
            <tr>
              <td></td>
              <td>CASH</td>
              <td>40500.00</td>
            </tr>
            <tr>
              <td></td>
              <td>ITEMS NUMBER</td>
              <td>1</td>
            </tr>
          </table>
          <div class="footer">
            <p>Printed on: ${new Date().toLocaleString()}</p>
            <p>CU Serial No: FT ANY LIAB</p>
            <p>CU Invoice N:0110691570000001198</p>
            <p>EO&E No 4172</p>
          </div>
        </body>
        </html>
        `;

        return receiptHTML;
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
             axios.get('/api/pmsunits/'+this.form.pms_property_id).then((response) => {
     
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
               const deposit = parseInt(this.unitinfo.deposit);
               const monthly_rent = parseInt(this.unitinfo.monthly_rent);
               const garbage_fee = parseInt(this.unitinfo.garbage_fee);
               const security_fee = parseInt(this.unitinfo.security_fee);
             this.depositRent = deposit + monthly_rent + garbage_fee + security_fee;
             this.unitNumber = this.unitinfo.unit_number;
             console.log("unitinfo", this.depositRent)
    
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
      submitStatement() {
       let self = this;  // Store the reference to this
       let payload = {
          mpesa_code: this.form.mpesa_code,
          payment_method: this.form.payment_method,
          paid: this.form.cash,
          balance: this.payableAmount,
          total: this.depositRent,
          pms_property_id: this.form.pms_property_id,
          unit_number: this.unitNumber,
          pms_tenant_id: this.tenantId
       };

       axios.post("api/pmsstatements", payload)
          .then(function (response) {
             console.log(response);
             // self.step = 1;
             toast.fire(
                'Success!',
                'Invoice saved!',
                'success'
             );
          })
          .catch(function (error) {
             console.log(error);
             // Swal.fire(
             //    'error!',
             //    // phone_error + id_error + pass_number,
             //    'error'
             // )
          });

       this.$router.push('/pmstenants');
      },

      formatNumber(value) {
        // Use the toLocaleString method to format the number with commas and decimal places
        return value.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      },       
 
    },
    mounted() {
       this.loadLists();
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