/*Cria tabela dos requisitos fincionais*/
CREATE TABLE rf (
	id_rf 					int NOT NULL AUTO_INCREMENT,
    nome 					varchar(62) NOT NULL,
	codigo 					varchar(6) NOT NULL,
	descricao 				text,
    status 					tinyint DEFAULT 1,
    criterio_aceitacao 		text,
    fonte 			 		varchar(300),
    prioridade 				tinyint,
    data_cadastro 			datetime,
    data_ultima_alteracao 	timestamp ON UPDATE CURRENT_TIMESTAMP,
    colaborador_atual 		int,
    ultimo_colaborador 		int,
    PRIMARY KEY (id_rf),
    UNIQUE (codigo)
)DEFAULT CHARSET = utf8;
/*Cria tabela dos requisitos não fincionais*/
CREATE TABLE rnf (
	id_rnf 					int NOT NULL AUTO_INCREMENT,
    nome 					varchar(62) NOT NULL,
	codigo 					varchar(7) NOT NULL,
	descricao 				text,
    status 					tinyint NOT NULL,
    criterio_aceitacao 		text,
    fonte 			 		varchar(300),
    prioridade 				tinyint,
    data_cadastro 			datetime,
    data_ultima_alteracao 	timestamp ON UPDATE CURRENT_TIMESTAMP,
    colaborador_atual 		int,
    ultimo_colaborador 		int,
    PRIMARY KEY (id_rnf)
)DEFAULT CHARSET = utf8;

/*Cria tabela das regras de negocio*/
CREATE TABLE rn (
	id_rn 					int NOT NULL AUTO_INCREMENT,
    codigo 					varchar(6) NOT NULL,
    descricao 				text,
    fonte 			 		varchar(300),
    data_cadastro 			datetime,
    data_ultima_alteracao 	timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_rn)
)DEFAULT CHARSET = utf8;

/*Cria tabela da rastreabilidade*/
CREATE TABLE rastreabilidade(
	id_relacao		int NOT NULL AUTO_INCREMENT,
    id_rf_left		int,
    id_rf_right		int,
    id_rnf_left		int,
    id_rnf_right	int,
    id_rn			int,
    PRIMARY KEY (id_relacao),
    FOREIGN KEY (id_rf_left) REFERENCES rf(id_rf),
    FOREIGN KEY (id_rf_right) REFERENCES rf(id_rf),
    FOREIGN KEY (id_rnf_left) REFERENCES rnf(id_rnf),
    FOREIGN KEY (id_rnf_right) REFERENCES rnf(id_rnf),
    FOREIGN KEY (id_rn) REFERENCES rn(id_rn)
    
)DEFAULT CHARSET = utf8;

/*Cria tabela material_suporte*/
CREATE TABLE material_suporte(
	id_material_suporte			int NOT NULL AUTO_INCREMENT,
    nome 						varchar(62) NOT NULL,
	data_cadastro 				datetime,
    data_ultima_alteracao 		timestamp ON UPDATE CURRENT_TIMESTAMP,
    id_colaborador_cadastro		int,
    id_colaborador_atualizacao 	int,
    PRIMARY KEY (id_material_suporte)
)DEFAULT CHARSET = utf8;

/*Cria tabela andamento*/
CREATE TABLE andamento(
	id_andamento	int NOT NULL AUTO_INCREMENT,
    descricao		text,
    tipo			smallint NOT NULL,
    data_cadastro 	datetime,
    inicio_trabalho	timestamp,
    fim_trabalho	timestamp,
    id_rf			int,
    id_rnf			int,
    /*esperando campo que ajude no versionamento*/
    PRIMARY KEY (id_andamento),
    FOREIGN KEY (id_rf) REFERENCES rf(id_rf),
    FOREIGN KEY (id_rnf) REFERENCES rnf(id_rnf)
)DEFAULT CHARSET = utf8;

/*Cria tabela requisito_ligacao_material_suporte*/
CREATE TABLE requisito_ligacao_material_suporte(
	id_relacao_r_s		int NOT NULL AUTO_INCREMENT,
    id_rf				int,
    id_rnf				int,
    id_rn				int,
    id_material_suporte int,
    PRIMARY KEY (id_relacao_r_s),
    FOREIGN KEY (id_rf) REFERENCES rf(id_rf),
    FOREIGN KEY (id_rnf) REFERENCES rnf(id_rnf),
    FOREIGN KEY (id_rn) REFERENCES rn(id_rn),
    FOREIGN KEY (id_material_suporte) REFERENCES material_suporte(id_material_suporte)
)DEFAULT CHARSET = utf8;

/*Cria tabela colaborador*/
CREATE TABLE colaborador(
	id_colaborador		int NOT NULL AUTO_INCREMENT,
    nome_colaborador	varchar(62) NOT NULL,
    PRIMARY KEY (id_colaborador)
)DEFAULT CHARSET = utf8;