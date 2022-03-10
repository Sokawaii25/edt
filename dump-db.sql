--
-- PostgreSQL database dump
--

-- Dumped from database version 13.6
-- Dumped by pg_dump version 13.3

-- Started on 2022-03-10 11:03:06

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: symfony
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO symfony;

--
-- TOC entry 3077 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: symfony
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 200 (class 1259 OID 16385)
-- Name: avis; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.avis (
    id integer NOT NULL,
    professeur_id integer,
    note smallint NOT NULL,
    commentaire text NOT NULL,
    email_etudiant character varying(255) NOT NULL,
    cours_id integer
);


ALTER TABLE public.avis OWNER TO symfony;

--
-- TOC entry 201 (class 1259 OID 16391)
-- Name: avis_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.avis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.avis_id_seq OWNER TO symfony;

--
-- TOC entry 202 (class 1259 OID 16393)
-- Name: cours; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.cours (
    id integer NOT NULL,
    matiere_id integer NOT NULL,
    salle_id integer NOT NULL,
    professeur_id integer NOT NULL,
    date_heure_debut timestamp(0) without time zone NOT NULL,
    date_heure_fin timestamp(0) without time zone NOT NULL,
    type character varying(20) NOT NULL
);


ALTER TABLE public.cours OWNER TO symfony;

--
-- TOC entry 203 (class 1259 OID 16396)
-- Name: cours_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.cours_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cours_id_seq OWNER TO symfony;

--
-- TOC entry 204 (class 1259 OID 16398)
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO symfony;

--
-- TOC entry 205 (class 1259 OID 16402)
-- Name: matiere; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.matiere (
    id integer NOT NULL,
    titre character varying(255) NOT NULL,
    reference character varying(255) NOT NULL
);


ALTER TABLE public.matiere OWNER TO symfony;

--
-- TOC entry 206 (class 1259 OID 16408)
-- Name: matiere_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.matiere_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.matiere_id_seq OWNER TO symfony;

--
-- TOC entry 207 (class 1259 OID 16410)
-- Name: professeur; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.professeur (
    id integer NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    email character varying(255) NOT NULL
);


ALTER TABLE public.professeur OWNER TO symfony;

--
-- TOC entry 208 (class 1259 OID 16416)
-- Name: professeur_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.professeur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.professeur_id_seq OWNER TO symfony;

--
-- TOC entry 209 (class 1259 OID 16418)
-- Name: professeur_matiere; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.professeur_matiere (
    professeur_id integer NOT NULL,
    matiere_id integer NOT NULL
);


ALTER TABLE public.professeur_matiere OWNER TO symfony;

--
-- TOC entry 210 (class 1259 OID 16421)
-- Name: salle; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.salle (
    id integer NOT NULL,
    numero smallint NOT NULL
);


ALTER TABLE public.salle OWNER TO symfony;

--
-- TOC entry 211 (class 1259 OID 16424)
-- Name: salle_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.salle_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.salle_id_seq OWNER TO symfony;

--
-- TOC entry 212 (class 1259 OID 16426)
-- Name: user; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL
);


ALTER TABLE public."user" OWNER TO symfony;

--
-- TOC entry 213 (class 1259 OID 16432)
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO symfony;

--
-- TOC entry 3058 (class 0 OID 16385)
-- Dependencies: 200
-- Data for Name: avis; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.avis (id, professeur_id, note, commentaire, email_etudiant, cours_id) FROM stdin;
25	8	2	Professeur très rapide dans ses explications, nous n'avons pas le temps de prendre des notes ! 	lboisse@univ-pau.fr	\N
31	\N	5	Oui très bien! Bravo!	SuperEleve@gmail.com	56
\.


--
-- TOC entry 3060 (class 0 OID 16393)
-- Dependencies: 202
-- Data for Name: cours; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.cours (id, matiere_id, salle_id, professeur_id, date_heure_debut, date_heure_fin, type) FROM stdin;
5	2	2	8	2022-03-11 08:30:00	2022-03-11 11:00:00	Cours
7	3	3	7	2022-03-07 16:00:00	2022-03-07 17:30:00	TP
55	4	3	8	2022-03-10 08:00:00	2022-03-10 10:00:00	Cours
56	2	1	8	2022-03-09 15:30:00	2022-03-09 17:00:00	TP
57	7	10	11	2022-03-10 10:00:00	2022-03-10 12:00:00	Cours
58	5	13	12	2022-03-10 13:00:00	2022-03-10 17:00:00	Cours
59	6	7	9	2022-03-11 11:00:00	2022-03-11 13:00:00	TD
60	1	8	10	2022-03-11 14:00:00	2022-03-11 16:30:00	TP
\.


--
-- TOC entry 3062 (class 0 OID 16398)
-- Dependencies: 204
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
\.


--
-- TOC entry 3063 (class 0 OID 16402)
-- Dependencies: 205
-- Data for Name: matiere; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.matiere (id, titre, reference) FROM stdin;
1	Prog web	UE1 - Programmation web avancée
3	Prog Distrib	UE1 - Programmation Distribuée
2	Anglais	LP LV1 Anglais
4	Big Data	UE1 - SIG & BIG DATA
5	Projet	UE - Projet
6	Prog Android	UE - Programmation Mobile
7	Micro-Contrôleurs	UE - Micro Contrôleurs
\.


--
-- TOC entry 3065 (class 0 OID 16410)
-- Dependencies: 207
-- Data for Name: professeur; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.professeur (id, nom, prenom, email) FROM stdin;
7	Levalois	Antoine	a.levalois@gmail.com
8	Dupont	Michel	michel.dupont@education.fr
9	Delacroix	Dylan	dylan.lacroix@gmail.com
10	Desousa	Emile	emile.desousa@gmail.com
11	Nivelle	Johana	johana.nivelle@education.fr
12	Kavel	Marc	marc.kavel@yahoo.com
\.


--
-- TOC entry 3067 (class 0 OID 16418)
-- Dependencies: 209
-- Data for Name: professeur_matiere; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.professeur_matiere (professeur_id, matiere_id) FROM stdin;
7	1
8	1
\.


--
-- TOC entry 3068 (class 0 OID 16421)
-- Dependencies: 210
-- Data for Name: salle; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.salle (id, numero) FROM stdin;
1	15
2	129
3	118
4	23
5	24
6	25
7	26
8	27
9	28
10	29
11	119
12	123
13	1
\.


--
-- TOC entry 3070 (class 0 OID 16426)
-- Dependencies: 212
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public."user" (id, email, roles, password) FROM stdin;
1	admin@admin.admin	[]	$2y$13$m37XbcSS4jttcMPqFXDe5uozXKOe79JG7jYPyY33ZznjwY.HFwAh2
4	matt@blabla.com	[]	$2y$13$XLROiNhqcNw2J9flZO12wuTraKJdSK/ChbODdVezXpOBRws6dTwtK
2	ahornec@univ-pau.fr	["ROLE_USER","ROLE_ADMIN"]	$2y$13$xK6CC2uanXq9YG6n0DzrbO8ZZUV338OB2pOW.FrmiFDOCk1n8hq3G
\.


--
-- TOC entry 3078 (class 0 OID 0)
-- Dependencies: 201
-- Name: avis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.avis_id_seq', 32, true);


--
-- TOC entry 3079 (class 0 OID 0)
-- Dependencies: 203
-- Name: cours_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.cours_id_seq', 60, true);


--
-- TOC entry 3080 (class 0 OID 0)
-- Dependencies: 206
-- Name: matiere_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.matiere_id_seq', 7, true);


--
-- TOC entry 3081 (class 0 OID 0)
-- Dependencies: 208
-- Name: professeur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.professeur_id_seq', 12, true);


--
-- TOC entry 3082 (class 0 OID 0)
-- Dependencies: 211
-- Name: salle_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.salle_id_seq', 13, true);


--
-- TOC entry 3083 (class 0 OID 0)
-- Dependencies: 213
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.user_id_seq', 4, true);


--
-- TOC entry 2896 (class 2606 OID 16435)
-- Name: avis avis_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.avis
    ADD CONSTRAINT avis_pkey PRIMARY KEY (id);


--
-- TOC entry 2900 (class 2606 OID 16437)
-- Name: cours cours_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT cours_pkey PRIMARY KEY (id);


--
-- TOC entry 2905 (class 2606 OID 16439)
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- TOC entry 2907 (class 2606 OID 16441)
-- Name: matiere matiere_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.matiere
    ADD CONSTRAINT matiere_pkey PRIMARY KEY (id);


--
-- TOC entry 2915 (class 2606 OID 16443)
-- Name: professeur_matiere professeur_matiere_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.professeur_matiere
    ADD CONSTRAINT professeur_matiere_pkey PRIMARY KEY (professeur_id, matiere_id);


--
-- TOC entry 2910 (class 2606 OID 16445)
-- Name: professeur professeur_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.professeur
    ADD CONSTRAINT professeur_pkey PRIMARY KEY (id);


--
-- TOC entry 2917 (class 2606 OID 16447)
-- Name: salle salle_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.salle
    ADD CONSTRAINT salle_pkey PRIMARY KEY (id);


--
-- TOC entry 2920 (class 2606 OID 16449)
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- TOC entry 2897 (class 1259 OID 16450)
-- Name: idx_8f91abf07ecf78b0; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_8f91abf07ecf78b0 ON public.avis USING btree (cours_id);


--
-- TOC entry 2898 (class 1259 OID 16451)
-- Name: idx_8f91abf0bab22ee9; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_8f91abf0bab22ee9 ON public.avis USING btree (professeur_id);


--
-- TOC entry 2912 (class 1259 OID 16452)
-- Name: idx_fbc82abcbab22ee9; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_fbc82abcbab22ee9 ON public.professeur_matiere USING btree (professeur_id);


--
-- TOC entry 2913 (class 1259 OID 16453)
-- Name: idx_fbc82abcf46cd258; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_fbc82abcf46cd258 ON public.professeur_matiere USING btree (matiere_id);


--
-- TOC entry 2901 (class 1259 OID 16454)
-- Name: idx_fdca8c9cbab22ee9; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_fdca8c9cbab22ee9 ON public.cours USING btree (professeur_id);


--
-- TOC entry 2902 (class 1259 OID 16455)
-- Name: idx_fdca8c9cdc304035; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_fdca8c9cdc304035 ON public.cours USING btree (salle_id);


--
-- TOC entry 2903 (class 1259 OID 16456)
-- Name: idx_fdca8c9cf46cd258; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_fdca8c9cf46cd258 ON public.cours USING btree (matiere_id);


--
-- TOC entry 2911 (class 1259 OID 16457)
-- Name: uniq_17a55299e7927c74; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_17a55299e7927c74 ON public.professeur USING btree (email);


--
-- TOC entry 2918 (class 1259 OID 16458)
-- Name: uniq_8d93d649e7927c74; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);


--
-- TOC entry 2908 (class 1259 OID 16459)
-- Name: uniq_9014574aaea34913; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_9014574aaea34913 ON public.matiere USING btree (reference);


--
-- TOC entry 2921 (class 2606 OID 16460)
-- Name: avis fk_8f91abf07ecf78b0; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.avis
    ADD CONSTRAINT fk_8f91abf07ecf78b0 FOREIGN KEY (cours_id) REFERENCES public.cours(id);


--
-- TOC entry 2922 (class 2606 OID 16465)
-- Name: avis fk_8f91abf0bab22ee9; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.avis
    ADD CONSTRAINT fk_8f91abf0bab22ee9 FOREIGN KEY (professeur_id) REFERENCES public.professeur(id);


--
-- TOC entry 2926 (class 2606 OID 16470)
-- Name: professeur_matiere fk_fbc82abcbab22ee9; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.professeur_matiere
    ADD CONSTRAINT fk_fbc82abcbab22ee9 FOREIGN KEY (professeur_id) REFERENCES public.professeur(id) ON DELETE CASCADE;


--
-- TOC entry 2927 (class 2606 OID 16475)
-- Name: professeur_matiere fk_fbc82abcf46cd258; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.professeur_matiere
    ADD CONSTRAINT fk_fbc82abcf46cd258 FOREIGN KEY (matiere_id) REFERENCES public.matiere(id) ON DELETE CASCADE;


--
-- TOC entry 2923 (class 2606 OID 16480)
-- Name: cours fk_fdca8c9cbab22ee9; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT fk_fdca8c9cbab22ee9 FOREIGN KEY (professeur_id) REFERENCES public.professeur(id);


--
-- TOC entry 2924 (class 2606 OID 16485)
-- Name: cours fk_fdca8c9cdc304035; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT fk_fdca8c9cdc304035 FOREIGN KEY (salle_id) REFERENCES public.salle(id);


--
-- TOC entry 2925 (class 2606 OID 16490)
-- Name: cours fk_fdca8c9cf46cd258; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT fk_fdca8c9cf46cd258 FOREIGN KEY (matiere_id) REFERENCES public.matiere(id);


-- Completed on 2022-03-10 11:03:06

--
-- PostgreSQL database dump complete
--

