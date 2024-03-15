<template>
    <TheMaster>

    <section class="section">
          <div class="row">
            <div class="col-lg-6">

              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Statement Details</h5>

                  <div class="row">
                    <div class="col-lg-6 col-md-4 label "><strong>{{name}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">{{form.first_name}} {{form.last_name}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label"><strong>0{{phoneNumber}}</strong></div>
                    <!-- <div class="col-lg-9 col-md-8">(254) {{form.phone}}</div> -->
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label"><strong>{{tenant}}</strong></div>
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
                      <th scope="col">Reference</th>
                      <th scope="col">Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td v-if="status == 1" scope="row"><span style="color: green;">Paid</span></td>
                      <td v-else scope="row"><span style="color: red;">Unpaid</span></td>
                      <td>{{formatNumber(paid)}}</td>
                      <td>{{refNo}}</td>
                      <td>{{formatNumber(balance)}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Rate</th>
                      <td></td>
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
                    <h5 class="card-title">Edit Statement</h5>
                
                    <form
                    class="row g-3 needs-validation"
                    novalidate=""
                    method="post"
                    autocomplete="off"
                    @submit.prevent="submit()"
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
                          >Rate:</label
                        >
                        <input type="number" v-model="form.total" class="form-control" id="inputEmail5">
                      </div>
                    </div>
             
                    <div class="row mb-3"></div>

                    <div class="col-md-6">
                    <label for="inputEmail5" class="form-label">Amount Paid</label>
                    <input type="number" v-model="form.paid" class="form-control" id="inputEmail5">
                    </div>
                    <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">Balance</label><br>
                     <h6>{{payableAmount}}</h6>

                    </div>        
                    <div class="row mb-3"></div>
                    <div class="col-lg-12 felx mt-4 row">
                        <div class="col-sm-6 col-lg-6">
                        <button @click.prevent="cancel()" class="btn btn-dark">Cancel</button>
                        </div>
                        <div class="col-sm-6 col-lg-6 text-end">
                        <button @click.prevent="submit()" class="btn btn-primary">Submit</button>
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
            form:
            {
              payment_method: '',
              cash: '',
              mpesa_code: '',
              balance: ''
            }
        }
    },
    components: {
      TheMaster,
    }, 
    methods:
    {
      getStatement()
      {
          axios.get('/api/pmsstatement/'+this.$route.params.id).then((response) => {
              this.statement = response.data.pmsstatement[0]
              this.name = this.statement.property.name;
              this.firstName = this.statement.tenant.first_name;
              this.lastName = this.statement.tenant.last_name;
              this.tenant = this.firstName + " " + this.lastName;
              this.phoneNumber = this.statement.tenant.phone_number;
              this.unitNumber = this.statement.tenant.pms_unit_id;
              this.refNo = this.statement.ref_no;
              this.details = this.statement.details;
              this.date = this.statement.created_at;
              this.status = this.statement.status;
              this.paid = this.statement.paid;
              this.balance = this.statement.balance;
              this.total = this.statement.total;
              this.form.total = this.statement.total;
              this.form.balance = this.statement.balance;
              this.form.paid = this.statement.paid;
              console.log("statement", this.statement)
          })
      },
      getUnit()
      {
        axios.get('/api/pmsunit/'+parseInt(this.unitNumber)).then((response) => {
          console.log("unit", response)
        })
      },
      cancel()
      {
        this.$router.push('/statements')
      },
      submit() {
          let data = { // Use let to declare the variable
              total: this.form.total,
              paid: this.form.paid,
              balance: this.payableAmount
          }; // Remove the comma here

          axios.put("/api/pmsstatement/" + this.$route.params.id, data)
              .then((response) => { // Use arrow function to retain 'this' context
                  console.log(response);
                  // this.step = 1;
                  toast.fire(
                      'Success!',
                      'Statement updated!',
                      'success'
                  );
              })
              .catch((error) => { // Use arrow function to retain 'this' context
                  console.log(error);
                  // Swal.fire(
                  //    'error!',
                  //    // phone_error + id_error + pass_number,
                  //    'error'
                  // )
              });

          this.$router.push('/statements');
      },
      formatNumber(value) {
        // Use the toLocaleString method to format the number with commas and decimal places
        return value.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      },
    },
    mounted()
    {
      this.getStatement();
      this.getUnit();
    },
    computed: {
        payableAmount() {
        return this.form.total - this.form.paid; // Multiply inputValue by 2 (change this multiplier as needed)
        },
    },
}
</script>