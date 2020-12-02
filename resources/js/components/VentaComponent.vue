<template>
    <div>
        <b-modal ref="modal-venta" hide-footer no-close-on-backdrop :title="tituloModal" size="xl"> 
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success my-3" @click="agregarNuevaVenta"><i class="fas fa-plus-square mr-2"></i>Agregar venta</button>
                </div>          
                <div class="col-md-4">
                    <label for="cliente_id">Cliente</label>
                    <b-form-select v-model="venta.cliente_id" :options="clientes"></b-form-select>
                </div>      
                <div class="col-md-4">
                    <label for="factura">No. factura</label>
                    <input type="text" class="form-control" v-model="venta.factura">
                    <span class="text-danger text-small">{{errores.factura}}</span>
                </div>
                <div class="col-md-4">
                    <label for="producto">Producto</label>
                    <b-form-select v-model="datosVenta.producto_id" :options="inventarios" @input="agregaPrecioProducto"></b-form-select>
                </div>                
                <div class="col-md-4">
                    <label for="">Precio del producto</label>
                    <input type="number" class="form-control" v-model="datosVenta.precio" readonly>
                </div>
                <div class="col-md-4">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" v-model.number="datosVenta.cantidad" min="0" :max="cantidadMaxima">
                    <span class="text-info">No. de productos en stock: {{cantidadMaxima}}</span>
                </div>
                <div class="col-md-4">
                    <label for="">Valor de la venta</label>
                    <input type="number" class="form-control" :value="calculaPrecioVenta" >
                </div>
                <div class="col-md-6 mb-2">
                    <label for="total">Total venta</label>
                    <input type="number" class="form-control" v-model="venta.total" readonly>
                    <input type="hidden" class="form-control" v-model="venta.total">
                </div>
                <div class="col-md-12" v-for="(item, index) in venta.ventas" :key="index">
                    <p class="alert alert-info">Producto: {{item.desc_producto}}  Cantidad: {{item.cantidad}} = ${{item.precio * item.cantidad}}</p>
                </div>
                <div class="mt-2 col-md-12">
                    <button class="btn btn-primary" v-if="btnCrear" @click="guardarVenta">Guardar venta</button>
                </div>
                <div class="col-md-12 mt-2" v-if="respuestaOk">
                    <p class="alert alert-success">Venta guardada</p>
                </div>
            </div>
        </b-modal>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>Ventas</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="nuevaVenta" ><i class="fas fa-plus-square mr-2"></i>Nueva venta</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Detalle venta</th>
                    <th>Cliente</th>
                    <th>No. factura</th>
                    <th>Total venta</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in ventas" :key="index">
                    <td>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" :data-target="'#collapse' + item.id" aria-expanded="false" @click="getDetalleVenta(item.id)">
                            Detalle
                        </button>                        
                        <div class="collapse mt-2" :id="'collapse' + item.id">
                            <div class="card card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in detalleventa" :key="index">
                                            <td>{{item.productos.nombre}}</td>
                                            <td>{{item.productos.precio}}</td>
                                            <td>{{item.cantidad}}</td>
                                            <td>{{item.productos.precio * item.cantidad}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td>{{item.clientes.nombres}} {{item.clientes.apellidos}}</td>
                    <td>{{item.factura}}</td>
                    <td>{{item.total}}</td>
                    <td>{{item.created_at}}</td>
                    <td>
                        <button class="btn btn-danger" @click="imprimirFactura(item.id)">Imprimir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import { jsPDF } from "jspdf";
    export default {
        data() {
            return {
                btnCrear: true,
                clientes: [],
                cantidadMaxima: 0,
                datosVenta: {producto_id: '', cantidad: 0, precio: 0},
                detalleventa: [],      
                doc: {},          
                errores: '',
                inventarios: [],
                respuestaOk: false,
                tituloModal: '',
                venta:{id: '', cliente_id: '', total: 0, factura: '', ventas: []},
                ventas: []
            }
        },
        mounted() {
            this.getClientes();
            this.getInventarios();
            this.getVentas();
        },
        methods: {
            agregarNuevaVenta(){
                this.venta.ventas.push({
                    producto_id: this.datosVenta.producto_id.id,
                    desc_producto: this.datosVenta.producto_id.desc,
                    precio: this.datosVenta.producto_id.precio,
                    cantidad: this.datosVenta.cantidad
                });

                let total = 0;

                for (let i = 0; i < this.venta.ventas.length; i++) {
                    total += parseInt(this.venta.ventas[i].precio) * parseInt(this.venta.ventas[i].cantidad);   
                }

                this.venta.total = total;

                this.datosVenta.producto_id = '';
                this.datosVenta.cantidad = 0;
                this.datosVenta.proveedore_id = '';
                this.datosVenta.precio = 0;                
                
            },
            agregaPrecioProducto(){
                this.datosVenta.precio = this.datosVenta.producto_id.precio;
                this.cantidadMaxima = this.datosVenta.producto_id.cantidad;
            },
            getClientes(){
                axios.get('/clientes')
                    .then(res => {
                        for (let i = 0; i < res.data.length; i++) {
                            this.clientes.push({
                                value: res.data[i].id,
                                text: res.data[i].nombres + res.data[i].apellidos
                            });
                        }
                    })
            },
            getDetalleVenta(id){
                axios.get(`/ventaproductos/${id}`)
                    .then(res => {
                        this.detalleventa = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getInventarios(){
                axios.get('/inventario')
                    .then(res => {
                        // console.log(res.data)
                        for (let i = 0; i < res.data.length; i++) {
                            this.inventarios.push({
                                value: {id: res.data[i].producto_id, precio: res.data[i].productos.precio, desc: res.data[i].productos.nombre, cantidad: res.data[i].stock},
                                text: res.data[i].productos.nombre,
                            });
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getVentas(){
                axios.get('/ventas')
                    .then(res => {
                        this.ventas = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarVenta(){
                if(this.venta.ventas.length === 0 || this.venta.cliente_id === '' || this.venta.factura === '' || this.venta.total === 0 ){
                    alert('Hay campos vacios, revise');
                    return;
                }

                axios.post('/ventas', this.venta)
                    .then(res => {
                        console.log(res.data);
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getVentas();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            imprimirFactura(id){
                this.doc = new jsPDF();
                axios.get(`/ventas/${id}`)
                    .then(res => {
                        console.log(res.data)
                        
                        const datos=res.data;
                        
                        this.doc.text(datos.empresas.razon_social, 10, 10);
                        this.doc.text(datos.empresas.nit, 150, 10);
                        this.doc.text("No. Factura: "+datos.factura, 10, 30);
                        this.doc.text("Cliente: "+datos.clientes.id+' - '+datos.clientes.nombres +' '+datos.clientes.apellidos, 10, 40);

                        this.doc.text('Detalle de la venta', 10, 60);

                        this.doc.text('Producto', 10, 70);
                        this.doc.text('Precio unitario', 80, 70);
                        this.doc.text('Cantidad', 120, 70);
                        this.doc.text('Precio total', 170, 70);

                        let columnas = 80;

                        this.doc.setFontSize(10);
                        
                        for (let i = 0; i < datos.ventaproductos.length; i++) {
                            columnas += 10*i;
                            this.doc.text(datos.productos[i].nombre +' - '+datos.productos[i].marca, 10, columnas);
                            this.doc.text(''+datos.productos[i].precio, 80, columnas);
                            this.doc.text(''+datos.ventaproductos[i].cantidad, 120, columnas);
                            this.doc.text(''+datos.ventaproductos[i].cantidad * datos.productos[i].precio, 170, columnas);
                        }

                        this.doc.setFontSize(14);
                        this.doc.text('Total venta', 10, columnas
                        + 10);

                        this.doc.text(''+datos.total, 170, columnas
                        + 10);

                        this.doc.text('Fecha de venta: '+datos.created_at, 10, columnas
                        + 30);
                        
                        
                        this.doc.save("a4.pdf");
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            nuevaVenta(){
                this.tituloModal = 'Nueva venta';
                this.errores = '';
                this.datosVenta = {producto_id: '', cantidad: 0, precio: 0};
                this.venta = {id: '', cliente_id: '', total: 0, factura: '', fecha: '', ventas: []};
                this.respuestaOk = false;
                this.$refs['modal-venta'].show();
            }
        },
        computed: {
            calculaPrecioVenta(){
                return this.datosVenta.producto_id.precio * this.datosVenta.cantidad;
            },
        },
    }
</script>