<template>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 ">
            <h4>Registrar transaccion</h4>
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <transaction-product-modal :products="products"
                                               v-on:addToCart="addToCartMethod">
                    </transaction-product-modal>

                    <button class="btn btn-success font-weight-bold text-white"
                            @click.prevent="submitTransaction"
                            :disabled="addedProducts.length === 0 || disable">Registrar transacciónes</button>
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
                                <button @click.prevent="addToCartMethod(product)" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <button @click.prevent="removeToCartMethod(product)" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TransactionProductModal from './TenantTransactionProductModal';
    import swal from 'sweetalert';

    export default {
        name: "Transaction",
        props: ['products', 'branchOffice'],
        data() {
          return {
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
                this.storeTransaction();
            },
            storeTransaction(){
                axios.post(`/${this.branchOffice.slug}/transactions`, {
                    products: this.addedProducts,
                }).then(response => {
                    swal("¡Buen trabajo!", response.data.data, "success");
                    setTimeout(() => { location.reload(); }, 4000);
                }).catch(error => {
                    swal("¡Oh no!", JSON.stringify(error.response.data), "error");
                });
            }
        }
    }
</script>
