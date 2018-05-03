--
-- "ppsi-2017-gr1"QL database dump
--

-- Dumped from database version 9.6.6
-- Dumped by pg_dump version 9.6.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: alerta; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE alerta (
    idalerta integer NOT NULL,
    descricao character varying(100) NOT NULL,
    alerta_tipo_idalerta_tipo integer NOT NULL
);


ALTER TABLE alerta OWNER TO "ppsi-2017-gr1";

--
-- Name: alerta_idalerta_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE alerta_idalerta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alerta_idalerta_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: alerta_idalerta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE alerta_idalerta_seq OWNED BY alerta.idalerta;


--
-- Name: alerta_tipo; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE alerta_tipo (
    idalerta_tipo integer NOT NULL,
    nome character varying(100) NOT NULL
);


ALTER TABLE alerta_tipo OWNER TO "ppsi-2017-gr1";

--
-- Name: alerta_tipo_idalerta_tipo_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE alerta_tipo_idalerta_tipo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alerta_tipo_idalerta_tipo_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: alerta_tipo_idalerta_tipo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE alerta_tipo_idalerta_tipo_seq OWNED BY alerta_tipo.idalerta_tipo;


--
-- Name: aluno; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE aluno (
    idaluno integer NOT NULL,
    pessoa_idpessoa integer NOT NULL,
    funcionario_idfuncionario integer NOT NULL,
    datainscricao date NOT NULL,
    estado_idestado integer NOT NULL
);


ALTER TABLE aluno OWNER TO "ppsi-2017-gr1";

--
-- Name: aluno_idaluno_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE aluno_idaluno_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aluno_idaluno_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: aluno_idaluno_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE aluno_idaluno_seq OWNED BY aluno.idaluno;


--
-- Name: aula; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE aula (
    idaula integer NOT NULL,
    dia date NOT NULL,
    hora time without time zone NOT NULL,
    funcionario_idfuncionario integer,
    categoria_idcategoria integer
);


ALTER TABLE aula OWNER TO "ppsi-2017-gr1";

--
-- Name: aula_idaula_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE aula_idaula_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aula_idaula_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: aula_idaula_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE aula_idaula_seq OWNED BY aula.idaula;


--
-- Name: aulapratica; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE aulapratica (
    idaulapratica integer NOT NULL,
    aula_idaula integer NOT NULL,
    veiculo_idveiculo integer,
    observacao character varying(250),
    aluno_idaluno integer NOT NULL,
    estadoaula_idestadoaula integer
);


ALTER TABLE aulapratica OWNER TO "ppsi-2017-gr1";

--
-- Name: aulapratica_idaulapratica_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE aulapratica_idaulapratica_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aulapratica_idaulapratica_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: aulapratica_idaulapratica_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE aulapratica_idaulapratica_seq OWNED BY aulapratica.idaulapratica;


--
-- Name: aulateorica; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE aulateorica (
    idaulateorica integer NOT NULL,
    aula_idaula integer NOT NULL,
    modulo_idmodulo integer NOT NULL
);


ALTER TABLE aulateorica OWNER TO "ppsi-2017-gr1";

--
-- Name: aulateorica_idaulateorica_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE aulateorica_idaulateorica_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aulateorica_idaulateorica_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: aulateorica_idaulateorica_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE aulateorica_idaulateorica_seq OWNED BY aulateorica.idaulateorica;


--
-- Name: categoria; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE categoria (
    idcategoria integer NOT NULL,
    designacao character varying(50) NOT NULL,
    preco money NOT NULL,
    aulasprevistat integer,
    aulasprevistasp integer NOT NULL,
    informacoesadicionais text NOT NULL
);


ALTER TABLE categoria OWNER TO "ppsi-2017-gr1";

--
-- Name: categoria_aluno; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE categoria_aluno (
    categoria_idcategoria integer NOT NULL,
    aluno_idaluno integer NOT NULL
);


ALTER TABLE categoria_aluno OWNER TO "ppsi-2017-gr1";

--
-- Name: categoria_func; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE categoria_func (
    funcionario_idfuncionario integer NOT NULL,
    categoria_idcategoria integer NOT NULL
);


ALTER TABLE categoria_func OWNER TO "ppsi-2017-gr1";

--
-- Name: categoria_idcategoria_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE categoria_idcategoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE categoria_idcategoria_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: categoria_idcategoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE categoria_idcategoria_seq OWNED BY categoria.idcategoria;


--
-- Name: estado; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE estado (
    idestado integer NOT NULL,
    descricao character varying(50) NOT NULL
);


ALTER TABLE estado OWNER TO "ppsi-2017-gr1";

--
-- Name: estado_idestado_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE estado_idestado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE estado_idestado_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: estado_idestado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE estado_idestado_seq OWNED BY estado.idestado;


--
-- Name: estadoaula; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE estadoaula (
    idestadoaula integer NOT NULL,
    descricao character varying(250)
);


ALTER TABLE estadoaula OWNER TO "ppsi-2017-gr1";

--
-- Name: estadoaula_idestadoaula_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE estadoaula_idestadoaula_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE estadoaula_idestadoaula_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: estadoaula_idestadoaula_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE estadoaula_idestadoaula_seq OWNED BY estadoaula.idestadoaula;


--
-- Name: exame; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE exame (
    idexame integer NOT NULL,
    aula_idaula integer NOT NULL,
    veiculo_idveiculo integer NOT NULL,
    localizacao character varying(100) NOT NULL,
    aluno_idaluno integer NOT NULL
);


ALTER TABLE exame OWNER TO "ppsi-2017-gr1";

--
-- Name: exame_idexame_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE exame_idexame_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE exame_idexame_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: exame_idexame_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE exame_idexame_seq OWNED BY exame.idexame;


--
-- Name: funcionario; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE funcionario (
    idfuncionario integer NOT NULL,
    administrador boolean DEFAULT false NOT NULL,
    instrutorteorica boolean NOT NULL,
    instrutorpratica boolean NOT NULL,
    pessoa_idpessoa integer NOT NULL,
    activo boolean DEFAULT true NOT NULL
);


ALTER TABLE funcionario OWNER TO "ppsi-2017-gr1";

--
-- Name: funcionario_idfuncionario_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE funcionario_idfuncionario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE funcionario_idfuncionario_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: funcionario_idfuncionario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE funcionario_idfuncionario_seq OWNED BY funcionario.idfuncionario;


--
-- Name: modulo; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE modulo (
    idmodulo integer NOT NULL,
    descricao character varying(100) NOT NULL
);


ALTER TABLE modulo OWNER TO "ppsi-2017-gr1";

--
-- Name: modulo_idmodulo_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE modulo_idmodulo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE modulo_idmodulo_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: modulo_idmodulo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE modulo_idmodulo_seq OWNED BY modulo.idmodulo;


--
-- Name: pergunta; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE pergunta (
    idpergunta integer NOT NULL,
    funcionario_idfuncionario integer NOT NULL,
    aluno_idaluno integer NOT NULL,
    titulo character varying(100) NOT NULL,
    pergunta character varying(250) NOT NULL,
    resposta character varying(250),
    faqs boolean,
    respondido boolean DEFAULT false NOT NULL
);


ALTER TABLE pergunta OWNER TO "ppsi-2017-gr1";

--
-- Name: pergunta_idpergunta_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE pergunta_idpergunta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pergunta_idpergunta_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: pergunta_idpergunta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE pergunta_idpergunta_seq OWNED BY pergunta.idpergunta;


--
-- Name: pessoa; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE pessoa (
    idpessoa integer NOT NULL,
    nome character varying(100) NOT NULL,
    telefone integer NOT NULL,
    email character varying(50) NOT NULL,
    datanascimento date NOT NULL,
    morada character varying(100) NOT NULL,
    username character varying(100) NOT NULL,
    password character varying(250) NOT NULL,
    contribuinte integer NOT NULL,
    facebook_id bigint
);


ALTER TABLE pessoa OWNER TO "ppsi-2017-gr1";

--
-- Name: pessoa_alerta; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE pessoa_alerta (
    pessoa_idpessoa integer NOT NULL,
    alerta_idalerta integer NOT NULL,
    alertavista boolean DEFAULT false NOT NULL,
    destino character varying(100) NOT NULL
);


ALTER TABLE pessoa_alerta OWNER TO "ppsi-2017-gr1";

--
-- Name: pessoa_idpessoa_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE pessoa_idpessoa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pessoa_idpessoa_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: pessoa_idpessoa_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE pessoa_idpessoa_seq OWNED BY pessoa.idpessoa;


--
-- Name: veiculo; Type: TABLE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE TABLE veiculo (
    idveiculo integer NOT NULL,
    marca character varying(50) NOT NULL,
    modelo character varying(50) NOT NULL,
    matricula character varying(10) NOT NULL,
    categoria_idcategoria integer
);


ALTER TABLE veiculo OWNER TO "ppsi-2017-gr1";

--
-- Name: veiculo_idveiculo_seq; Type: SEQUENCE; Schema: public; Owner: "ppsi-2017-gr1"
--

CREATE SEQUENCE veiculo_idveiculo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE veiculo_idveiculo_seq OWNER TO "ppsi-2017-gr1";

--
-- Name: veiculo_idveiculo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER SEQUENCE veiculo_idveiculo_seq OWNED BY veiculo.idveiculo;


--
-- Name: alerta idalerta; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY alerta ALTER COLUMN idalerta SET DEFAULT nextval('alerta_idalerta_seq'::regclass);


--
-- Name: alerta_tipo idalerta_tipo; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY alerta_tipo ALTER COLUMN idalerta_tipo SET DEFAULT nextval('alerta_tipo_idalerta_tipo_seq'::regclass);


--
-- Name: aluno idaluno; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aluno ALTER COLUMN idaluno SET DEFAULT nextval('aluno_idaluno_seq'::regclass);


--
-- Name: aula idaula; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aula ALTER COLUMN idaula SET DEFAULT nextval('aula_idaula_seq'::regclass);


--
-- Name: aulapratica idaulapratica; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica ALTER COLUMN idaulapratica SET DEFAULT nextval('aulapratica_idaulapratica_seq'::regclass);


--
-- Name: aulateorica idaulateorica; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulateorica ALTER COLUMN idaulateorica SET DEFAULT nextval('aulateorica_idaulateorica_seq'::regclass);


--
-- Name: categoria idcategoria; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria ALTER COLUMN idcategoria SET DEFAULT nextval('categoria_idcategoria_seq'::regclass);


--
-- Name: estado idestado; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY estado ALTER COLUMN idestado SET DEFAULT nextval('estado_idestado_seq'::regclass);


--
-- Name: estadoaula idestadoaula; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY estadoaula ALTER COLUMN idestadoaula SET DEFAULT nextval('estadoaula_idestadoaula_seq'::regclass);


--
-- Name: exame idexame; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY exame ALTER COLUMN idexame SET DEFAULT nextval('exame_idexame_seq'::regclass);


--
-- Name: funcionario idfuncionario; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY funcionario ALTER COLUMN idfuncionario SET DEFAULT nextval('funcionario_idfuncionario_seq'::regclass);


--
-- Name: modulo idmodulo; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY modulo ALTER COLUMN idmodulo SET DEFAULT nextval('modulo_idmodulo_seq'::regclass);


--
-- Name: pergunta idpergunta; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pergunta ALTER COLUMN idpergunta SET DEFAULT nextval('pergunta_idpergunta_seq'::regclass);


--
-- Name: pessoa idpessoa; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa ALTER COLUMN idpessoa SET DEFAULT nextval('pessoa_idpessoa_seq'::regclass);


--
-- Name: veiculo idveiculo; Type: DEFAULT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY veiculo ALTER COLUMN idveiculo SET DEFAULT nextval('veiculo_idveiculo_seq'::regclass);


--
-- Data for Name: alerta; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO alerta VALUES (1, 'Pedidos de Aulas pendentes', 4);
INSERT INTO alerta VALUES (2, 'Pedidos de cancelamento pendentes', 4);


--
-- Name: alerta_idalerta_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('alerta_idalerta_seq', 2, true);


--
-- Data for Name: alerta_tipo; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO alerta_tipo VALUES (1, 'Aulas');
INSERT INTO alerta_tipo VALUES (2, 'Exames');
INSERT INTO alerta_tipo VALUES (3, 'Duvidas');
INSERT INTO alerta_tipo VALUES (4, 'Pedidos');


--
-- Name: alerta_tipo_idalerta_tipo_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('alerta_tipo_idalerta_tipo_seq', 4, true);


--
-- Data for Name: aluno; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: aluno_idaluno_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('aluno_idaluno_seq', 1, false);


--
-- Data for Name: aula; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: aula_idaula_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('aula_idaula_seq', 1, false);


--
-- Data for Name: aulapratica; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: aulapratica_idaulapratica_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('aulapratica_idaulapratica_seq', 1, false);


--
-- Data for Name: aulateorica; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: aulateorica_idaulateorica_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('aulateorica_idaulateorica_seq', 1, false);


--
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO categoria VALUES (1, 'Categoria A', '300,00 ', NULL, 12, '');
INSERT INTO categoria VALUES (2, 'Categoria B', '500,00 ', NULL, 32, '');
INSERT INTO categoria VALUES (3, 'Categoria C', '700,00 ', NULL, 32, '');


--
-- Data for Name: categoria_aluno; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Data for Name: categoria_func; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: categoria_idcategoria_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('categoria_idcategoria_seq', 3, true);


--
-- Data for Name: estado; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO estado VALUES (1, 'Iniciar');
INSERT INTO estado VALUES (2, 'Teorica Completada');
INSERT INTO estado VALUES (3, 'Pratica Completada');
INSERT INTO estado VALUES (4, 'Inscricao Anulada');


--
-- Name: estado_idestado_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('estado_idestado_seq', 4, true);


--
-- Data for Name: estadoaula; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO estadoaula VALUES (1, 'Pedido de Aula');
INSERT INTO estadoaula VALUES (2, 'Aula Marcada');
INSERT INTO estadoaula VALUES (3, 'Pedido de Cancelamento');
INSERT INTO estadoaula VALUES (4, 'Cancelado');
INSERT INTO estadoaula VALUES (5, 'Concluida');


--
-- Name: estadoaula_idestadoaula_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('estadoaula_idestadoaula_seq', 5, true);


--
-- Data for Name: exame; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: exame_idexame_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('exame_idexame_seq', 1, false);


--
-- Data for Name: funcionario; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO funcionario VALUES (1, true, true, true, 1, true);


--
-- Name: funcionario_idfuncionario_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('funcionario_idfuncionario_seq', 1, true);


--
-- Data for Name: modulo; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: modulo_idmodulo_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('modulo_idmodulo_seq', 1, false);


--
-- Data for Name: pergunta; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: pergunta_idpergunta_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('pergunta_idpergunta_seq', 1, false);


--
-- Data for Name: pessoa; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO pessoa VALUES (1, 'Secretaria', 234756221, 'driveawaypsi@gmail.com', '2010-10-10', 'ruas', 'root', '$2y$10$7UxnwIL.18zd7o6.vDqkoutlE4BTd07WG0igia3DXSFc3L7OML07i', 111111111, NULL);


--
-- Data for Name: pessoa_alerta; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--

INSERT INTO pessoa_alerta VALUES (1, 1, false, 'pedidos/gestaopedidos.php');
INSERT INTO pessoa_alerta VALUES (1, 2, false, 'pedidos/gestaopedidos.php');


--
-- Name: pessoa_idpessoa_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('pessoa_idpessoa_seq', 1, true);


--
-- Data for Name: veiculo; Type: TABLE DATA; Schema: public; Owner: "ppsi-2017-gr1"
--



--
-- Name: veiculo_idveiculo_seq; Type: SEQUENCE SET; Schema: public; Owner: "ppsi-2017-gr1"
--

SELECT pg_catalog.setval('veiculo_idveiculo_seq', 1, false);


--
-- Name: alerta alerta_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY alerta
    ADD CONSTRAINT alerta_pk PRIMARY KEY (idalerta);


--
-- Name: alerta_tipo alerta_tipo_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY alerta_tipo
    ADD CONSTRAINT alerta_tipo_pk PRIMARY KEY (idalerta_tipo);


--
-- Name: aluno aluno_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aluno
    ADD CONSTRAINT aluno_pk PRIMARY KEY (idaluno);


--
-- Name: aula aula_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aula
    ADD CONSTRAINT aula_pk PRIMARY KEY (idaula);


--
-- Name: aulapratica aulapratica_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica
    ADD CONSTRAINT aulapratica_pk PRIMARY KEY (idaulapratica);


--
-- Name: aulateorica aulateorica_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulateorica
    ADD CONSTRAINT aulateorica_pk PRIMARY KEY (idaulateorica);


--
-- Name: categoria categoria_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria
    ADD CONSTRAINT categoria_pk PRIMARY KEY (idcategoria);


--
-- Name: estado estado_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY estado
    ADD CONSTRAINT estado_pk PRIMARY KEY (idestado);


--
-- Name: estadoaula estadoaula_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY estadoaula
    ADD CONSTRAINT estadoaula_pk PRIMARY KEY (idestadoaula);


--
-- Name: exame exame_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY exame
    ADD CONSTRAINT exame_pk PRIMARY KEY (idexame);


--
-- Name: funcionario funcionario_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY funcionario
    ADD CONSTRAINT funcionario_pk PRIMARY KEY (idfuncionario);


--
-- Name: modulo modulo_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY modulo
    ADD CONSTRAINT modulo_pk PRIMARY KEY (idmodulo);


--
-- Name: pergunta pergunta_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pergunta
    ADD CONSTRAINT pergunta_pk PRIMARY KEY (idpergunta);


--
-- Name: pessoa pessoa_email_username_contribuinte_key; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa
    ADD CONSTRAINT pessoa_email_username_contribuinte_key UNIQUE (email, username, contribuinte);


--
-- Name: pessoa pessoa_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa
    ADD CONSTRAINT pessoa_pk PRIMARY KEY (idpessoa);


--
-- Name: pessoa pessoa_telefone_key; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa
    ADD CONSTRAINT pessoa_telefone_key UNIQUE (telefone);

ALTER TABLE ONLY exame
    ADD CONSTRAINT exame_aluno_idaluno UNIQUE (aluno_idaluno);



--
-- Name: veiculo veiculo_pk; Type: CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY veiculo
    ADD CONSTRAINT veiculo_pk PRIMARY KEY (idveiculo);


--
-- Name: alerta alerta_alerta_tipo; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY alerta
    ADD CONSTRAINT alerta_alerta_tipo FOREIGN KEY (alerta_tipo_idalerta_tipo) REFERENCES alerta_tipo(idalerta_tipo);


--
-- Name: aluno aluno_estado; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aluno
    ADD CONSTRAINT aluno_estado FOREIGN KEY (estado_idestado) REFERENCES estado(idestado);


--
-- Name: aluno aluno_funcionario; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aluno
    ADD CONSTRAINT aluno_funcionario FOREIGN KEY (funcionario_idfuncionario) REFERENCES funcionario(idfuncionario);


--
-- Name: aluno aluno_pessoa; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aluno
    ADD CONSTRAINT aluno_pessoa FOREIGN KEY (pessoa_idpessoa) REFERENCES pessoa(idpessoa);


--
-- Name: aula aula_categoria; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aula
    ADD CONSTRAINT aula_categoria FOREIGN KEY (categoria_idcategoria) REFERENCES categoria(idcategoria);


--
-- Name: aula aula_funcionario; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aula
    ADD CONSTRAINT aula_funcionario FOREIGN KEY (funcionario_idfuncionario) REFERENCES funcionario(idfuncionario);


--
-- Name: aulapratica aulapratica_aluno; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica
    ADD CONSTRAINT aulapratica_aluno FOREIGN KEY (aluno_idaluno) REFERENCES aluno(idaluno);


--
-- Name: aulapratica aulapratica_aula; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica
    ADD CONSTRAINT aulapratica_aula FOREIGN KEY (aula_idaula) REFERENCES aula(idaula);


--
-- Name: aulapratica aulapratica_estadoaula; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica
    ADD CONSTRAINT aulapratica_estadoaula FOREIGN KEY (estadoaula_idestadoaula) REFERENCES estadoaula(idestadoaula);


--
-- Name: aulapratica aulapratica_veiculo; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulapratica
    ADD CONSTRAINT aulapratica_veiculo FOREIGN KEY (veiculo_idveiculo) REFERENCES veiculo(idveiculo);


--
-- Name: aulateorica aulateorica_aula; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulateorica
    ADD CONSTRAINT aulateorica_aula FOREIGN KEY (aula_idaula) REFERENCES aula(idaula);


--
-- Name: aulateorica aulateorica_modulo; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY aulateorica
    ADD CONSTRAINT aulateorica_modulo FOREIGN KEY (modulo_idmodulo) REFERENCES modulo(idmodulo);


--
-- Name: categoria_aluno categoria_aluno_aluno; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria_aluno
    ADD CONSTRAINT categoria_aluno_aluno FOREIGN KEY (aluno_idaluno) REFERENCES aluno(idaluno);


--
-- Name: categoria_aluno categoria_aluno_categoria; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria_aluno
    ADD CONSTRAINT categoria_aluno_categoria FOREIGN KEY (categoria_idcategoria) REFERENCES categoria(idcategoria);


--
-- Name: categoria_func categoria_func_categoria; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria_func
    ADD CONSTRAINT categoria_func_categoria FOREIGN KEY (categoria_idcategoria) REFERENCES categoria(idcategoria);


--
-- Name: categoria_func categoria_func_funcionario; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY categoria_func
    ADD CONSTRAINT categoria_func_funcionario FOREIGN KEY (funcionario_idfuncionario) REFERENCES funcionario(idfuncionario);


--
-- Name: exame exame_aluno; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY exame
    ADD CONSTRAINT exame_aluno FOREIGN KEY (aluno_idaluno) REFERENCES aluno(idaluno);


--
-- Name: exame exame_aula; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY exame
    ADD CONSTRAINT exame_aula FOREIGN KEY (aula_idaula) REFERENCES aula(idaula);


--
-- Name: exame exame_veiculo; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY exame
    ADD CONSTRAINT exame_veiculo FOREIGN KEY (veiculo_idveiculo) REFERENCES veiculo(idveiculo);


--
-- Name: funcionario funcionario_pessoa; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY funcionario
    ADD CONSTRAINT funcionario_pessoa FOREIGN KEY (pessoa_idpessoa) REFERENCES pessoa(idpessoa);


--
-- Name: pergunta pergunta_aluno; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pergunta
    ADD CONSTRAINT pergunta_aluno FOREIGN KEY (aluno_idaluno) REFERENCES aluno(idaluno);


--
-- Name: pergunta pergunta_funcionario; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pergunta
    ADD CONSTRAINT pergunta_funcionario FOREIGN KEY (funcionario_idfuncionario) REFERENCES funcionario(idfuncionario);


--
-- Name: pessoa_alerta pessoa_alerta_alerta; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa_alerta
    ADD CONSTRAINT pessoa_alerta_alerta FOREIGN KEY (alerta_idalerta) REFERENCES alerta(idalerta);


--
-- Name: pessoa_alerta pessoa_alerta_pessoa; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY pessoa_alerta
    ADD CONSTRAINT pessoa_alerta_pessoa FOREIGN KEY (pessoa_idpessoa) REFERENCES pessoa(idpessoa);


--
-- Name: veiculo veiculo_categoria; Type: FK CONSTRAINT; Schema: public; Owner: "ppsi-2017-gr1"
--

ALTER TABLE ONLY veiculo
    ADD CONSTRAINT veiculo_categoria FOREIGN KEY (categoria_idcategoria) REFERENCES categoria(idcategoria);


--
-- Name: public; Type: ACL; Schema: -; Owner: "ppsi-2017-gr1"
--

GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- "ppsi-2017-gr1"QL database dump complete
--

