<template>
    <TheMaster>

    <section class="section">
          <div class="row">
            <div class="col-lg-6">

              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Statement Details</h5>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label "><strong>{{name}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.first_name}} {{form.last_name}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>0{{phoneNumber}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">(254) {{form.phone}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>{{tenant}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.email}}</div> -->
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>Ref No: {{refNo}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{refNo}}</div> -->
                  </div> 
                  <div class="row">
                    <div class="col-lg-12 col-md-4 label"><strong>{{details}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{refNo}}</div> -->
                  </div>                                                     
                </div>

                <div class="row mb-3"></div>
                <!-- Default Table -->
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Status</th>
                      <th scope="col">Paid</th>
                      <th scope="col">Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td v-if="status == 1" scope="row"><span style="color: green;">Settled</span></td>
                      <td v-else scope="row"><span style="color: red;">Unsettled</span></td>
                      <td>{{formatNumber(paid)}}</td>
                      <td>{{formatNumber(balance)}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Due</th>
                      <td></td>
                      <td>KES. {{formatNumber(total)}}</td>
                    </tr> 
                  </tbody>
                </table>
                <!-- End Default Table Example -->       
                <div class="row mb-3"></div>                
              </div>

            </div>

            <div class="col-lg-6">

            <div class="card px-2">
                    <div class="card-body">
                    <h5 class="card-title">Settle Invoice</h5>
                
                    <form
                    class="row g-3 needs-validation"
                    novalidate=""
                    method="post"
                    autocomplete="off"
                    >
                    <div class="row mb-3"></div>
                    <div class="form-group row">
                      <label v-if="lastmonthBalance < 0" for="validationCustom04" class="form-label"
                          ><span style="color: green;">Overpayment: <strong>KES {{lastmonthstatement.balance}}</strong></span>              
                      </label>

                      <label v-if="lastmonthstatement.balance > 0" for="validationCustom04" class="form-label"
                        ><span style="color: red;">Last Month Arrears: <strong>KES {{lastmonthstatement.balance}}</strong></span></label
                      >
                      <div class="col-sm-12">
                        <label for="validationCustom04" class="form-label"
                          >Please select payment method:</label
                        >
                        <div class="col-sm-10">
                            <select name="category" v-model="form.payment_method" class="form-select" id="">
                                <option value="0" disabled>Select Payment</option>
                                <option value="Mpesa" selected>MPESA (Paybill Number)</option>
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
                    <input type="number" :disabled="!form.payment_method" v-model="form.cash" class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">Balance</label><br>
                    
                     <h6 v-if="lastmonthBalance < 0">{{payableOverAmount}}</h6>
                     <h6 v-else>{{payableAmount}}</h6>
                    </div> 
                    <button v-if="lastmonthBalance < 0" @click.prevent="applyOverPayment" :disabled="!form.cash">Apply Overpayment</button>       
                    <div class="row mb-3"></div>
                    <div class="col-lg-12 felx mt-4 row">
                        <div class="col-sm-6 col-lg-6">
                        <button @click.prevent="cancel()" class="btn btn-dark">Back</button>
                        </div>
                       <div class="col-sm-6 col-lg-6 text-end">
                            <button @click.prevent="settleReceipt" type="submit" v-if="status == 0 && paid > 0" class="btn btn-darkgreen">Settle</button>
                            <button @click="printReceipt" v-else class="btn btn-orange">Print Receipt</button>
                        </div>

                    </div>
                  </form>
                
                    </div>
                </div>

                    </div>
            </div>
    </section>
    </TheMaster>
</template>

<script>
 import TheMaster from '@/components/dashboard/TheMaster.vue'
 import axios from 'axios';
 import Swal from 'sweetalert2';
 import moment from 'moment';

 const toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
  });
  
  window.toast = toast;
export default{
    data(){
        return {
            name: '',
            tenant: '',
            phoneNumber: '',
            unitNumber: '',
            refNo: '',
            details: '',
            date: '',
            status: '',
            paid: '',
            balance: '',
            total: '',
            isAmountValid: true,
            lastmonthstatement: [],
            lastmonthBalance: '',
            overPayment: false,

            form:
            {
              payment_method: '',
              cash: '',
              mpesa_code: '',
              balance: '',
              amountPaid: '',
              balAmount: ''
            }
        }
    },
    components: {
      TheMaster,
    }, 
    methods:
    {
      async settleReceipt() {
          // Call settleTenant method and wait for it to complete
          await this.settleTenant();

          // Proceed with the rest of the function after settleTenant completes
          // this.$router.push('/statements');
              this.$router.go(-1);

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
          toast.fire(
              'Success!',
              'Invoice updated!',
              'success'
          );
      },
      getCurrentTimestamp() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      },
      settleTenant() {
          return new Promise((resolve, reject) => {
              let payload; // Define payload variable outside the if-else blocks
              this.paid_at = this.getCurrentTimestamp();

              if (this.lastmonthBalance >= 0) {
                  payload = {
                      mpesa_code: this.form.mpesa_code,
                      payment_method: this.form.payment_method,
                      paid: this.paid + this.form.cash,
                      balance: this.payableAmount,
                      paid_at: this.paid_at
                  };
              } else {
                  payload = {
                      mpesa_code: this.form.mpesa_code,
                      payment_method: this.form.payment_method,
                      paid: this.paid,
                      balance: this.payableOverAmount,
                      paid_at: this.paid_at
                  };
              }

              if (this.lastmonthBalance < 0) {
                  this.updateLastMonthStatement();
              }

              axios.put("/api/pmssettlestatement/" + this.$route.params.id, payload)
                  .then(response => {
                      console.log(response);
                      this.statement = response.data.statement;
                      this.amountPaid = this.statement.paid;
                      this.balAmount = this.statement.balance;
                      // self.step = 1;
                      // toast.fire(
                      //     'Success!',
                      //     'Invoice updated!',
                      //     'success'
                      // );
                      resolve(); // Resolve the promise when settleTenant completes successfully
                  })
                  .catch(error => {
                      console.log(error);
                      reject(error); // Reject the promise if there's an error
                  });
          });
      },



      submit() {
        return new Promise((resolve, reject) => {
            let self = this;  // Store the reference to this
            this.paid_at = this.getCurrentTimestamp();
            let payload = {
                mpesa_code: this.form.mpesa_code,
                payment_method: this.form.payment_method,
                paid: this.form.cash,
                balance: this.payableAmount,
                paid_at: this.paid_at
            };

            axios.put("/api/pmssettlestatement/" + this.$route.params.id, payload)
                .then(function (response) {
                    console.log(response);
                    self.statement = response.data.statement;
                    self.amountPaid = self.statement.paid;
                    self.balAmount = self.statement.balance;
                    // self.step = 1;
                    // toast.fire(
                    //     'Success!',
                    //     'Invoice updated!',
                    //     'success'
                    // );
                    resolve(); // Resolve the promise once submission is successful
                })
                .catch(function (error) {
                    console.log(error);
                    reject(error); // Reject the promise if there's an error during submission
                });

                this.$router.go(-1);
        });
      },

      printReceipt() {
          this.submit().then(() => {
              // Continue with the rest of the function after submit completes
              // this.$router.push('/statements');
              this.$router.go(-1);

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
              toast.fire(
                  'Success!',
                  'Invoice updated!',
                  'success'
              );
          }).catch(error => {
              console.error("Error during submission:", error);
              // Handle error if needed
          });
      },


      buildReceiptContent(refNo) {
         // Determine whether to include the row
        const showGarbageFeeRow = this.unitGarbageFee !== 0;
        const showSecurityFeeRow = this.unitSecurityFee !== 0;
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
            }
            .receipt {
              max-width: 600px;
              margin: 20px auto;
              padding: 20px;
              background-color: #fff;
              border: 2px solid #ccc;
              border-radius: 10px;
            }
            .receipt-header {
              text-align: center;
              margin-bottom: 20px;
            }
            .receipt-header h1 {
              margin: 10px 0;
              color: #333;
            }
            .receipt-info {
              margin-bottom: 20px;
            }
            .receipt-info p {
              margin: 5px 0;
              color: #555;
            }
            .receipt-table {
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 20px;
            }
            .receipt-table th, .receipt-table td {
              padding: 8px;
              border-bottom: 1px solid #ccc;
            }
            .receipt-table th {
              text-align: left;
              background-color: #f2f2f2;
              color: #333;
            }
            .receipt-table td {
              text-align: left;
              color: #666;
            }
            .receipt-footer {
              text-align: center;
            }
            .receipt-footer p {
              margin: 5px 0;
              color: #777;
            }
          </style>
        </head>
        <body>
          <img src="@/assets/img/apex-logo.png" alt="Company Logo" style="display: block; margin: 0 auto; max-width: 100%;">

          <div class="receipt">
            <div class="receipt-header">
              <h1>April Properties</h1>
              <p>Kakamega-Webuye Rd, ACK Building</p>
              <p>Phone: (0720) 020-401 | Email: propertapril@gmail.com</p>
            </div>
            <div class="receipt-info">
              <p><strong>Invoice Number:</strong> ${this.refNo}</p>
              <p><strong>Receipt Date:</strong> ${new Date().toLocaleString()}</p>
              <p><strong>Rent Month:</strong> ${this.formatMonth(this.date)}</p>
              <p><strong>Tenant:</strong> ${this.tenant}</p>
              <p><strong>Property:</strong> ${this.name} - ${this.unitName}</p>
              <p><strong>Payment Mode:</strong> ${this.form.payment_method}</p>
            </div>
            <table class="receipt-table">
              <thead>
                <tr>
                  <th>Description</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Rent Payment</td>
                  <td>KES ${this.formatNumber(this.unitRent)}</td>
                </tr>
                <!-- Conditionally include garbage collection fee row -->
                ${showGarbageFeeRow ? `
                <tr>
                  <td>Garbage Collection Fee</td>
                  <td>KES ${this.formatNumber(this.unitGarbageFee)}</td>
                </tr>
                ` : ''}
                </tr>
                <!-- Conditionally include security fee row -->
                ${showSecurityFeeRow ? `
                <tr>
                  <td>Security Fee</td>
                  <td>KES ${this.formatNumber(this.unitSecurityFee)}</td>
                </tr>
                ` : ''}
              </tbody>
              <tfoot>
                <tr>
                  <th>Total Amount Due:</th>
                  <td>KES ${this.formatNumber(this.total)}</td>
                </tr>
                <tr>
                  <th>Amount Paid:</th>
                  <td>KES ${this.formatNumber(this.amountPaid)}</td>
                </tr>
                <tr>
                  <th>Balance:</th>
                  <td>KES ${this.formatNumber(this.balAmount)}</td>
                </tr>
              </tfoot>
            </table>
            <div class="receipt-footer">
              <p>You were served by ${this.user.first_name} ${this.user.last_name}.Thank you for your payment.</p>
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
      getStatement()
      {
          axios.get('/api/pmsstatement/'+this.$route.params.id).then((response) => {
              this.statement = response.data.pmsstatement[0]
              this.name = this.statement.property.name;
              this.firstName = this.statement.tenant.first_name;
              this.lastName = this.statement.tenant.last_name;
              this.tenant = this.firstName + " " + this.lastName;
              this.tenantId = this.statement.pms_tenant_id;
              this.phoneNumber = this.statement.tenant.phone_number;
              this.unitNumber = this.statement.tenant.pms_unit_id;
              this.getUnit(this.unitNumber);            
              this.refNo = this.statement.ref_no;
              this.details = this.statement.details;
              this.date = this.statement.created_at;
              this.status = this.statement.status;
              this.paid = this.statement.paid;
              this.balance = this.statement.balance;
              this.total = this.statement.total;
              console.log("statement", this.statement)
          })
      },
      getUnit(unitNumber) {
          axios.get('/api/pmsunit/' + parseInt(unitNumber))
              .then((response) => {
                this.unit = response.data.unit;
                this.unitName = this.unit.unit_number;
                this.unitRent = this.unit.monthly_rent;
                this.unitSecurityFee = this.unit.security_fee;
                this.unitGarbageFee = this.unit.garbage_fee;
                this.unitType = this.unit.type;
                  console.log("unit", this.unit);
                  // Further processing of the response data if needed
              })
              .catch((error) => {
                  console.error("Error fetching unit:", error);
              });
      },
      cancel()
      {
        this.$router.go(-1);
        // this.$router.push('/statements')
      },

      checkLastMonthStatement() {
          axios.get('/api/pmslastmonthtenantstatements/' + this.$route.params.tenantId)
              .then((response) => {
                  if (response.data?.pmslastmonthtenantstatements?.length > 0) {
                      this.lastmonthstatement = response.data.pmslastmonthtenantstatements[0];
                      this.lastmonthBalance = this.lastmonthstatement.balance;
                      console.log("OverPayment", this.lastmonthstatement);
                  } else {
                      console.log("No last month statement found for the tenant.");
                  }
              })
              .catch((error) => {
                  console.error("Error fetching last month tenant statements:", error);
              });
      },
      updateLastMonthStatement() {
          axios.put('/api/pmslastmonthtenantstatement/' + this.$route.params.tenantId)
              .then((response) => {
                      console.log("Tenant.", response);
              })
              .catch((error) => {
                  console.error("Error fetching last month tenant statements:", error);
              });
      },
      applyOverPayment()
      {
        this.overPayment = true;
        this.newTotal =  this.total + this.lastmonthstatement.balance;
        this.paid = -this.lastmonthstatement.balance + this.form.cash;
        console.log("changed", this.newTotal)
      },
      formatNumber(value) {
            // Check if the value is not a number
            if (isNaN(value)) {
                return value; // Return as it is
            }
            
            // Convert the value to a string
            let stringValue = value.toString();

            // Split the string into integer and decimal parts
            let parts = stringValue.split('.');

            // Format the integer part with commas
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // If there's a decimal part, limit it to 2 decimal places
            if (parts.length > 1) {
                parts[1] = parts[1].substring(0, 2);
            } else {
                parts.push('00'); // If no decimal part exists, append '00'
            }

            // Join the parts back together with a decimal point
            return parts.join('.');
      },
    },
    mounted()
    {
      this.getStatement();
      this.getUnit();
      this.checkLastMonthStatement();
      this.user = JSON.parse(localStorage.getItem('user'));      
    },
    computed: {
        payableAmount() {

            if (this.paid > 0) {
              return this.balance - this.form.cash;
            }
            else
            {
               return this.total - this.form.cash; // Multiply inputValue by 2 (change this multiplier as needed)
            } 
          
       
        },
        payableOverAmount() {
            return this.total - this.paid; // Multiply inputValue by 2 (change this multiplier as needed                              
        },         
    },
}
</script>

<style>
  .btn-darkgreen {
    background-color: darkgreen;
    border-color: darkgreen;
    color: #fff; /* Set text color to white */
}

.btn-orange {
    background-color: orange;
    border-color: orange;
    color: #fff; /* Set text color to white */
}
.section {
    padding: 20px;
}

.card {
    border-radius: 10px;
}

.card-title {
    font-size: 1.25rem;
}

.label {
    font-weight: bold;
    color: #333;
}

.row.mb-3 {
    margin-bottom: 1rem;
}

.row.mt-4 {
    margin-top: 1rem;
}

.text-end {
    text-align: right;
}

</style>