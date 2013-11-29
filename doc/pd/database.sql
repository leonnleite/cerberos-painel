

create table campeonato
(
   id_campeonato        int not null auto_increment,
   id_temporada         int not null,
   nm_campeonato        varchar(50) not null,
   primary key (id_campeonato)
);

create table campeonato_x_usuario
(
   id_campeonato_x_usuario int not null auto_increment,
   id_campeonato        int not null,
   id_usuario           int not null,
   primary key (id_campeonato_x_usuario)
);

create table clube
(
   id_clube             int not null auto_increment,
   id_pais              int not null,
   nm_clube             varchar(100) not null,
   primary key (id_clube)
);

create table configuracao
(
   id_configuracao      int not null,
   primary key (id_configuracao)
);

create table copa
(
   id_copa              int not null auto_increment,
   id_temporada         int not null,
   nm_copa              varchar(200) not null,
   primary key (id_copa)
);

create table grupo
(
   id_grupo             int not null auto_increment,
   id_copa              int not null,
   nm_grupo             varchar(200) not null,
   primary key (id_grupo)
);

create table grupo_x_usuario
(
   id_grupo_x_usuario   int not null auto_increment,
   id_grupo             int not null,
   id_usuario           int not null,
   primary key (id_grupo_x_usuario)
);

create table jogador
(
   id_jogador           int not null auto_increment,
   nm_abreviado         varchar(50) not null,
   nm_completo          varchar(50) not null,
   dt_nascimento        date not null,
   nu_altura            smallint not null,
   nu_peso              smallint not null,
   tx_pe_preferido      varchar(25) not null,
   id_pais              smallint not null,
   nu_overall           smallint not null,
   cd_po_preferida_1    varchar(3) not null,
   cd_po_preferida_2    varchar(3) not null,
   cd_po_preferida_3    varchar(3) not null,
   nu_aceleracao        smallint not null,
   nu_velocidade_final  smallint not null,
   nu_agilidade         smallint not null,
   nu_equilibrio        smallint not null,
   nu_pulo              smallint not null,
   nu_resistencia       smallint not null,
   nu_forca             smallint not null,
   nu_reacao            smallint not null,
   nu_agressao          smallint not null,
   nu_intercepcao       smallint not null,
   nu_posicionamento    smallint not null,
   nu_visao_jogo        smallint not null,
   nu_controle_bola     smallint not null,
   nu_cruzamento        smallint not null,
   nu_drible            smallint not null,
   nu_finalizacao       smallint not null,
   nu_cobranca_falta    smallint not null,
   nu_cabeceio          smallint not null,
   nu_passe_longo       smallint not null,
   nu_passe_curto       smallint not null,
   nu_marcacao          smallint not null,
   nu_forca_chute       smallint not null,
   nu_chute_longe       smallint not null,
   nu_roubada_bola      smallint not null,
   nu_carrinho          smallint not null,
   nu_voleios           smallint not null,
   nu_curva             smallint not null,
   nu_penaltis          smallint not null,
   nu_salto             smallint not null,
   nu_habilidade_mao    smallint not null,
   nu_habilidade_pe     smallint not null,
   nu_reflexo           smallint not null,
   nu_posicionamento_goleiro smallint not null,
   nu_potencial         smallint not null,
   nu_reputacao_internacional smallint not null,
   nu_pe_ruim           smallint not null,
   nu_dribles_habilidade smallint not null,
   tx_ataque            varchar(25) not null,
   tx_defesa            varchar(25) not null,
   id_clube             smallint not null,
   id_selecao           smallint not null,
   primary key (id_jogador)
);

create table jogador_proprietario
(
   id_jogador_proprietario int not null auto_increment,
   id_jogador           int not null,
   id_usuario           int not null,
   id_temporada         int not null,
   primary key (id_jogador_proprietario)
);

create table jogo
(
   id_jogo              int not null auto_increment,
   id_status            int not null,
   id_temporada         int not null,
   id_usuario_casa      int not null,
   id_usuario_visitante int not null,
   dt_jogo              date not null,
   primary key (id_jogo)
);

create table jogo_comentario
(
   id_comentario        int not null auto_increment,
   id_jogo              int not null,
   id_usuario           int not null,
   tx_comentario        text not null,
   dt_comentario        date not null,
   primary key (id_comentario)
);

create table jogo_resultado
(
   id_resultado         int not null auto_increment,
   id_jogo              int not null,
   id_jogador           int not null,
   id_status            int not null,
   nu_gols              int not null,
   nu_vermelho          int not null,
   nu_amarelo           int not null,
   dt_resultado         datetime not null default current_timestamp,
   primary key (id_resultado)
);

create table jogo_resultado_status
(
   id_status            int not null auto_increment,
   nm_status            varchar(50) not null,
   ds_status            varchar(200) not null,
   primary key (id_status)
);

create table jogo_status
(
   id_status            int not null auto_increment,
   nm_status            varchar(50) not null,
   ds_status            varchar(200) not null,
   primary key (id_status)
);

create table lance
(
   id_lance             int not null auto_increment,
   id_leilao            int not null,
   id_usuario           int not null,
   vl_lance             int not null,
   dt_lance             timestamp not null default current_timestamp,
   primary key (id_lance)
);

create table leilao
(
   id_leilao            int not null auto_increment,
   id_leilao_status     int not null,
   id_jogador           int not null,
   id_temporada         int not null,
   vl_inicial           int not null,
   vl_final             int not null,
   primary key (id_leilao)
);

create table leilao_status
(
   id_status            int not null auto_increment,
   nm_status            varchar(50) not null,
   ds_status            varchar(200) not null,
   primary key (id_status)
);

create table negociacao
(
   id_negociacao        int not null,
   primary key (id_negociacao)
);

create table notificacao
(
   id_notificacao       int not null,
   primary key (id_notificacao)
);

create table pais
(
   id_pais              int not null auto_increment,
   nm_pais              varchar(50) not null,
   nm_confederacao      varchar(50) not null,
   cd_pais              char(3) not null,
   primary key (id_pais)
);

create table selecao
(
   id_selecao           int not null auto_increment,
   id_pais              int not null,
   nm_selecao           varchar(100) not null,
   primary key (id_selecao)
);

create table serie
(
   id_serie             int not null auto_increment,
   nm_serie             char not null,
   primary key (id_serie)
);

create table temporada
(
   id_temporada         int not null auto_increment,
   id_temporada_status  int not null,
   dt_inicial           date not null,
   dt_final             date not null,
   primary key (id_temporada)
);

create table temporada_status
(
   id_status            int not null auto_increment,
   nm_status            varchar(50) not null,
   ds_status            varchar(200) not null,
   primary key (id_status)
);

create table transacao
(
   id_transacao         int not null auto_increment,
   id_transacao_tipo    int not null,
   id_usuario           int not null,
   dt_transacao         datetime not null,
   vl_transacao         int not null,
   ds_transacao         varchar(300) not null,
   primary key (id_transacao)
);

create table transacao_tipo
(
   id_tipo              int not null auto_increment,
   nm_tipo              varchar(50) not null,
   ds_tipo              varchar(200) not null,
   primary key (id_tipo)
);

create table usuario
(
   id_usuario           int not null auto_increment,
   nm_usuario           varchar(50) not null,
   tx_senha             varchar(32) not null,
   tx_email             varchar(50) not null,
   lg_live              varchar(50) not null,
   fg_perfil            int not null,
   primary key (id_usuario)
);

create table usuario_x_serie_x_temporada
(
   id_usuario_x_serie_x_temporada int not null auto_increment,
   id_serie             int not null,
   id_usuario           int not null,
   id_temporada         int not null,
   primary key (id_usuario_x_serie_x_temporada)
);

alter table campeonato add constraint fk_reference_19 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

alter table campeonato_x_usuario add constraint fk_reference_27 foreign key (id_campeonato)
      references campeonato (id_campeonato) on delete restrict on update restrict;

alter table campeonato_x_usuario add constraint fk_reference_28 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table clube add constraint fk_reference_43 foreign key (id_pais)
      references pais (id_pais) on delete restrict on update restrict;

alter table copa add constraint fk_reference_24 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

alter table grupo add constraint fk_reference_26 foreign key (id_copa)
      references copa (id_copa) on delete restrict on update restrict;

alter table grupo_x_usuario add constraint fk_reference_21 foreign key (id_grupo)
      references grupo (id_grupo) on delete restrict on update restrict;

alter table grupo_x_usuario add constraint fk_reference_25 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table jogador add constraint fk_reference_30 foreign key (id_pais)
      references pais (id_pais) on delete restrict on update restrict;

alter table jogador add constraint fk_reference_31 foreign key (id_selecao)
      references selecao (id_selecao) on delete restrict on update restrict;

alter table jogador add constraint fk_reference_32 foreign key (id_clube)
      references clube (id_clube) on delete restrict on update restrict;

alter table jogador_proprietario add constraint fk_reference_34 foreign key (id_jogador)
      references jogador (id_jogador) on delete restrict on update restrict;

alter table jogador_proprietario add constraint fk_reference_35 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table jogador_proprietario add constraint fk_reference_36 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

alter table jogo add constraint fk_reference_10 foreign key (id_usuario_visitante)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table jogo add constraint fk_reference_4 foreign key (id_status)
      references jogo_status (id_status) on delete restrict on update restrict;

alter table jogo add constraint fk_reference_7 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

alter table jogo add constraint fk_reference_9 foreign key (id_usuario_casa)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table jogo_comentario add constraint fk_reference_11 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table jogo_comentario add constraint fk_reference_2 foreign key (id_jogo)
      references jogo (id_jogo) on delete restrict on update restrict;

alter table jogo_resultado add constraint fk_reference_3 foreign key (id_jogo)
      references jogo (id_jogo) on delete restrict on update restrict;

alter table jogo_resultado add constraint fk_reference_33 foreign key (id_jogador)
      references jogador (id_jogador) on delete restrict on update restrict;

alter table jogo_resultado add constraint fk_reference_37 foreign key (id_status)
      references jogo_resultado_status (id_status) on delete restrict on update restrict;

alter table lance add constraint fk_reference_41 foreign key (id_leilao)
      references leilao (id_leilao) on delete restrict on update restrict;

alter table lance add constraint fk_reference_42 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table leilao add constraint fk_reference_38 foreign key (id_leilao_status)
      references leilao_status (id_status) on delete restrict on update restrict;

alter table leilao add constraint fk_reference_39 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

alter table leilao add constraint fk_reference_40 foreign key (id_jogador)
      references jogador (id_jogador) on delete restrict on update restrict;

alter table selecao add constraint fk_reference_14 foreign key (id_pais)
      references pais (id_pais) on delete restrict on update restrict;

alter table temporada add constraint fk_reference_29 foreign key (id_temporada_status)
      references temporada_status (id_status) on delete restrict on update restrict;

alter table transacao add constraint fk_reference_1 foreign key (id_transacao_tipo)
      references transacao_tipo (id_tipo) on delete restrict on update restrict;

alter table transacao add constraint fk_reference_16 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table usuario_x_serie_x_temporada add constraint fk_reference_20 foreign key (id_serie)
      references serie (id_serie) on delete restrict on update restrict;

alter table usuario_x_serie_x_temporada add constraint fk_reference_22 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table usuario_x_serie_x_temporada add constraint fk_reference_23 foreign key (id_temporada)
      references temporada (id_temporada) on delete restrict on update restrict;

