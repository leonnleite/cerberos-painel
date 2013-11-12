create table produto (
   id_produto           serial not null,
   nm_produto           varchar(50)          not null,
   vl_produto           float8               not null,
   st_ativo             int4                 not null default 1,
   constraint pk_produto primary key (id_produto),
   constraint un_nm_produto unique (nm_produto)
);

create unique index produto_pk on produto (
id_produto
);

create table promocao (
   id_promocao          serial not null,
   nm_promocao          varchar(50)          null,
   pc_promocao          int4                 not null,
   dt_validade          date                 not null default 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
   st_ativo             int4                 not null default 1,
   constraint pk_promocao primary key (id_promocao)
);

create unique index promocao_pk on promocao (
id_promocao
);

create table promocao_x_produto (
   id_promocao_x_produto serial not null,
   id_promocao          int4                 not null,
   id_produto           int4                 not null,
   constraint pk_promocao_x_produto primary key (id_promocao_x_produto)
);

create unique index promocao_x_produto_pk on promocao_x_produto (
id_promocao_x_produto
);

create  index reference_1_fk2 on promocao_x_produto (
id_produto
);

create  index reference_3_fk2 on promocao_x_produto (
id_promocao
);

create table usuario (
   id_usuario           serial not null,
   nm_usuario           varchar(50)          null,
   nu_cpf               varchar(11)          not null,
   fg_perfil            int4                 not null default 0,
   tx_email             varchar(50)          not null,
   tx_senha             varchar(32)          null,
   st_ativo             int4                 not null default 1,
   constraint pk_usuario primary key (id_usuario),
   constraint un_tx_email unique (tx_email),
   constraint un_nu_cpf unique (nu_cpf)
);

create unique index usuario_pk on usuario (
id_usuario
);

create table venda (
   id_venda             serial not null,
   id_usuario           int4                 not null,
   dt_venda             date                 not null default current_timestamp,
   vl_total             float8               not null,
   st_ativo             int4                 not null default 1,
   constraint pk_venda primary key (id_venda)
);

create unique index venda_pk on venda (
id_venda
);

create  index reference_4_fk2 on venda (
id_usuario
);

create table venda_x_produto (
   id_venda_x_produto   serial not null,
   id_venda             int4                 not null,
   id_produto           int4                 not null,
   vl_produto           float8               not null,
   qt_produto           int4                 not null,
   constraint pk_venda_x_produto primary key (id_venda_x_produto)
);

create unique index venda_x_produto_pk on venda_x_produto (
id_venda_x_produto
);

create  index reference_2_fk2 on venda_x_produto (
id_produto
);

create  index reference_5_fk2 on venda_x_produto (
id_venda
);

alter table promocao_x_produto
   add constraint fk_promocao_reference_produto foreign key (id_produto)
      references produto (id_produto)
      on delete restrict on update restrict;

alter table promocao_x_produto
   add constraint fk_promocao_reference_promocao foreign key (id_promocao)
      references promocao (id_promocao)
      on delete restrict on update restrict;

alter table venda
   add constraint fk_venda_reference_usuario foreign key (id_usuario)
      references usuario (id_usuario)
      on delete restrict on update restrict;

alter table venda_x_produto
   add constraint fk_venda_x__reference_produto foreign key (id_produto)
      references produto (id_produto)
      on delete restrict on update restrict;

alter table venda_x_produto
   add constraint fk_venda_x__reference_venda foreign key (id_venda)
      references venda (id_venda)
      on delete restrict on update restrict;

