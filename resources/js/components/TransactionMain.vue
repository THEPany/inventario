<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 float-md-left">
                <transaction-product-modal :products="products"
                                           v-on:addToCart="addToCartMethod">
                </transaction-product-modal>

                <br>

                <button class="btn btn-success btn-sm"
                        @click.prevent="submitTransaction"
                        :disabled="addedProducts.length === 0 || disable">Registrar transacciónes</button>
            </div>
            <div class="col-md-9 float-md-right">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Enviar a sucursal</label>

                    <div class="col-md-6">
                        <select class="form-control" v-model="branchOfficeId">
                            <option :value="null">Selecciona esta opción en caso de que no quieras enviar.</option>
                            <option v-for="branchOffice in branchOffices" :value="branchOffice.id">{{ branchOffice.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pt-5" v-if="addedProducts.length > 0">
                <table class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in addedProducts">
                        <td>{{ product.id}}</td>
                        <td>
                            {{ product.name }}
                            <br>
                            <a @click.prevent="deleteToCartMethod(product)" href="#">Eliminar</a>
                        </td>
                        <td>{{ product.quantity }}</td>
                        <td>
                            <textarea v-model="product.description" class="form-control" placeholder="Descripción de la transacion"></textarea>
                        </td>
                        <td>
                            <button @click.prevent="addToCartMethod(product)" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            <button @click.prevent="removeToCartMethod(product)" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import TransactionProductModal from './TransactionProductModal';
    import swal from 'sweetalert';

    export default {
        name: "Transaction",
        props: ['products', 'branchOffices'],
        data() {
          return {
              branchOfficeId: null,
              addedProducts: [],
              disable: false,
          }
        },
        components: {
            TransactionProductModal
        },
        methods: {
            addToCartMethod(product) {
                const record = this.addedProducts.find(p => p.id === product.id);

                if (record && record.maxStock === record.quantity ) {
                    return;
                }

                if (!record) {
                    this.addedProducts.push({
                        id: product.id,
                        name: product.name,
                        quantity: 1,
                        description: product.description,
                        maxStock: product.stock
                    })
                } else {
                    record.quantity++;
                }
            },
            removeToCartMethod(product) {
                const record = this.addedProducts.find(p => p.id === product.id);

                if (record && record.quantity === 0) {
                    this.deleteToCartMethod(product);
                    return;
                }

                record.quantity--;
            },
            deleteToCartMethod(product) {
                const record = this.addedProducts.find(p => p.id === product.id);
                this.addedProducts.splice(record, 1);
            },
            submitTransaction(){
                this.disable = true;
                if (this.branchOfficeId) {
                    this.storeTransactionPassProduct();
                    return;
                }
                this.storeTransaction();
            },
            storeTransactionPassProduct() {
                axios.post('/transactions/pass/product', {
                    branch_office_id: this.branchOfficeId,
                    products: this.addedProducts,
                }).then(response => {
                    swal("¡Buen trabajo!", response.data.data, "success");
                    setTimeout(() => { location.reload(); }, 4000);
                }).catch(error => {
                    swal("¡Oh no!", error, "error");
                });
            },
            storeTransaction(){
                axios.post('/transactions', {
                    products: this.addedProducts,
                }).then(response => {
                    swal("¡Buen trabajo!", response.data.data, "success");
                    setTimeout(() => { location.reload(); }, 4000);
                }).catch(error => {
                    swal("¡Oh no!", error, "error");
                });
            }
        }
    }
</script>
