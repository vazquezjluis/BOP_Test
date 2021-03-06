<?php
$config = 
        array('clientes' => array(
                                array(
                                	'field'=>'nomeCliente',
                                	'label'=>'Nome',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'documento',
                                	'label'=>'CPF/CNPJ',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'telefone',
                                	'label'=>'Telefone',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'email',
                                	'label'=>'Email',
                                	'rules'=>'required|trim|valid_email'
                                ),
								array(
                                	'field'=>'rua',
                                	'label'=>'Rua',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'numero',
                                	'label'=>'Número',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'bairro',
                                	'label'=>'Bairro',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'cidade',
                                	'label'=>'Cidade',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'estado',
                                	'label'=>'Estado',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'cep',
                                	'label'=>'CEP',
                                	'rules'=>'required|trim'
                                ))
                ,
                'servicos' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'preco',
                                    'label'=>'',
                                    'rules'=>'required|trim'
                                ))
                ,
                'fallas' => array(
                                array(
                                    'field'=>'tipo',
                                    'label'=>'tipo',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'descripcion',
                                    'label'=>'descripcion',
                                    'rules'=>'required|trim'
                                )
                    )
                ,
                'sala' => array(
                                array(
                                    'field'=>'txtTitulo',
                                    'label'=>'txtTitulo',
                                    'rules'=>'required|trim'
                                )
//                                ,
//                                array(
//                                    'field'=>'descripcion',
//                                    'label'=>'descripcion',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'descripcion',
//                                    'label'=>'descripcion',
//                                    'rules'=>'required|trim'
//                                )
                    )
                ,
                'menu' => array(
                                array(
                                    'field'=>'descripcion',
                                    'label'=>'descripcion',
                                    'rules'=>'required|trim'
                                )
                    )
                ,
                'maquinas' => array(
                                array(
                                    'field'=>'nro_egm',
                                    'label'=>'UID',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'fabricante',
                                    'label'=>'fabricante',
                                    'rules'=>'trim'
                                ),
//                                array(
//                                    'field'=>'modelo',
//                                    'label'=>'modelo',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'p_pago',
//                                    'label'=>'p_pago',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'denom',
//                                    'label'=>'denom',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'juego',
//                                    'label'=>'juego',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'nro_serie',
//                                    'label'=>'nro_serie',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'programa',
//                                    'label'=>'programa',
//                                    'rules'=>'required|trim'
//                                ),
//                                array(
//                                    'field'=>'credito',
//                                    'label'=>'credito',
//                                    'rules'=>'required|trim'
//                                )
                    )
                ,
                'articulos' => array(array(
                                    'field'=>'nombre',
                                    'label'=>'',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'categoria',
                                    'label'=>'Categoria',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'stock',
                                    'label'=>'Stock',
                                    'rules'=>'required|trim'
                                ))
                ,
                'usuarios' => array(array(
                                    'field'=>'nombre',
                                    'label'=>'Nombre',
                                    'rules'=>'required|trim'
                                ),
                                
//                                array(
//                                    'field'=>'legajo',
//                                    'label'=>'Legajo',
//                                    'rules'=>'required|trim'
//                                ),
                                
                                array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'required|trim'
                                ),
//                                array(
//                                    'field'=>'email',
//                                    'label'=>'Email',
//                                    'rules'=>'required|trim|valid_email'
//                                ),
                                array(
                                    'field'=>'clave',
                                    'label'=>'Clave',
                                    'rules'=>'required|trim'
                                ),
                                )
                ,      
                'os' => array(array(
                                    'field'=>'dataInicial',
                                    'label'=>'DataInicial',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'dataFinal',
                                    'label'=>'DataFinal',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'garantia',
                                    'label'=>'Garantia',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'descricaoProduto',
                                    'label'=>'DescricaoProduto',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'defeito',
                                    'label'=>'Defeito',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'status',
                                    'label'=>'Status',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'observacoes',
                                    'label'=>'Observacoes',
                                    'rules'=>'trim'
                                ),
                                array(
                                    'field'=>'clientes_id',
                                    'label'=>'clientes',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'usuarios_id',
                                    'label'=>'usuarios_id',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'laudoTecnico',
                                    'label'=>'Laudo Tecnico',
                                    'rules'=>'trim'
                                ))

                  ,
				'tiposUsuario' => array(array(
                                	'field'=>'nomeTipo',
                                	'label'=>'NomeTipo',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'situacao',
                                	'label'=>'Situacao',
                                	'rules'=>'required|trim'
                                ))

                ,
				'capacitacion' => array(
                                    array(
                                	'field'=>'tema',
                                	'label'=>'tema',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'modalidad',
                                	'label'=>'modalidad',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'evaluacion',
                                	'label'=>'evaluacion',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'tipo',
                                	'label'=>'tipo',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'obligatorio',
                                	'label'=>'obligatorio',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'f_inicio',
                                	'label'=>'f_inicio',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'f_fin',
                                	'label'=>'f_fin',
                                	'rules'=>'required|trim'
                                    ),
                                    array(
                                	'field'=>'cupo',
                                	'label'=>'cupo',
                                	'rules'=>'required|trim'
                                    )
                                    
                                )
                ,
				'licencia' => array(array(
                                	'field'=>'titulo',
                                	'label'=>'titulo',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'dias',
                                	'label'=>'dias',
                                	'rules'=>'required|trim'
                                ))
                ,
				'vincular_licencia' => array(array(
                                	'field'=>'persona_id',
                                	'label'=>'persona',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'licencia',
                                	'label'=>'licencia',
                                	'rules'=>'required|trim'
                                ))

                ,
				'vincular_capacitacion' => array(array(
                                	'field'=>'persona_id',
                                	'label'=>'persona',
                                	'rules'=>'required|trim'
                                ),
								array(
                                	'field'=>'capacitacion',
                                	'label'=>'capacitacion',
                                	'rules'=>'required|trim'
                                ))
                ,
				'vincular_premio' => array(
                                    array(
                                	'field'=>'persona_id',
                                	'label'=>'persona',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'premio',
                                	'label'=>'premio',
                                	'rules'=>'required|trim'
                                        )
                                )
                ,
				'vincular_estudio' => array(
                                    array(
                                	'field'=>'persona_id',
                                	'label'=>'persona',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'estudio',
                                	'label'=>'estudio',
                                	'rules'=>'required|trim'
                                        )
                                )
                ,
				'vincular_uniforme' => array(
                                    array(
                                	'field'=>'uniforme_id',
                                	'label'=>'uniforme_id',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'persona_id',
                                	'label'=>'persona_id',
                                	'rules'=>'required|trim'
                                        )
                                )
                ,
				'desempeno' => array(
                                    array(
                                	'field'=>'idPersona',
                                	'label'=>'persona',
                                	'rules'=>'required|trim'
                                        )
                                )
                ,
                                'premio' => array(
                                    array(
                                	'field'=>'nombre',
                                	'label'=>'nombre',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'tipo',
                                	'label'=>'tipo',
                                	'rules'=>'required|trim'
                                        )
                                    
                                )
                ,
                                'estudio' => array(
                                    array(
                                	'field'=>'titulo',
                                	'label'=>'titulo',
                                	'rules'=>'required|trim'
                                        )
                                    ,
                                    array(
                                	'field'=>'tipo',
                                	'label'=>'tipo',
                                	'rules'=>'required|trim'
                                        )
                                    ,
                                    array(
                                	'field'=>'institucion',
                                	'label'=>'institucion',
                                	'rules'=>'required|trim'
                                        )
                                    ,
                                    array(
                                	'field'=>'fecha',
                                	'label'=>'fecha',
                                	'rules'=>'required|trim'
                                        )
                                    
                                )
                ,
                                'seleccion_personal' => array(
                                    array(
                                	'field'=>'nombre',
                                	'label'=>'nombre',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'apellido',
                                	'label'=>'apellido',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'contacto',
                                	'label'=>'contacto',
                                	'rules'=>'required|trim'
                                        )
                                    
                                )
            ,
                                'uniforme' => array(
                                    array(
                                	'field'=>'prenda',
                                	'label'=>'prenda',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'tipo_prenda',
                                	'label'=>'tipo_prenda',
                                	'rules'=>'required|trim'
                                        ),
                                    array(
                                	'field'=>'talle',
                                	'label'=>'talle',
                                	'rules'=>'required|trim'
                                        )
                                    
                                )
                ,
                'receita' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim'
                                ),
                        
                                array(
                                    'field'=>'cliente',
                                    'label'=>'Cliente',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim'
                                ))
                ,
                'despesa' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'fornecedor',
                                    'label'=>'Fornecedor',
                                    'rules'=>'required|trim'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim'
                                ))
                ,
                'vendas' => array(array(

                                    'field' => 'dataVenda',
                                    'label' => 'Data da Venda',
                                    'rules' => 'required|trim'
                                ),
                                array(
                                    'field'=>'clientes_id',
                                    'label'=>'clientes',
                                    'rules'=>'trim|required'
                                ),
                                array(
                                    'field'=>'usuarios_id',
                                    'label'=>'usuarios_id',
                                    'rules'=>'trim|required'
                                ))
		);
			   