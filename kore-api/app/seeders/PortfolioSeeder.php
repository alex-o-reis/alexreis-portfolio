<?php

require_once __DIR__ . '/../../kore/Seeder.php';
require_once __DIR__ . '/../../kore/Model.php';

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProfile();
        $this->seedExperiences();
        $this->seedSkills();
        $this->seedEducation();
        $this->seedProjects();
    }

    private function j($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function seedProfile(): void
    {
        $summary = [
            'pt' => [
                'eyebrow' => 'LIDERANÇA DE ENGENHARIA · ARQUITETURA · IA',
                'hero_title' => 'Liderança de engenharia <em>além do código.</em>',
                'hero_lead' => 'Projeto software confiável, lidero equipes de engenharia e transformo desafios complexos de negócio em plataformas feitas para evoluir.',
                'aside_tag' => 'SOFTWARE / SISTEMAS / PESSOAS',
                'about_title' => 'Decisões técnicas que <em>transformam organizações.</em>',
                'about_paragraphs' => [
                    'Minha carreira conecta desenvolvimento prático, arquitetura e liderança técnica transversal. Na Emccamp, fui o único líder técnico das equipes de Obras, IA e Backoffice, reunindo até 30 profissionais.',
                    'Idealizei a modernização de uma plataforma corporativa crítica, ajudei a estabelecer práticas de entrega orientadas a produto e criei um protótipo de agente de IA que contribuiu para formar a equipe de P&D em IA.',
                    'Antes, na Vox Populi, ajudei a estruturar um departamento de desenvolvimento, liderei nove profissionais e construí plataformas integradas para mais de 100 equipes de pesquisa no Brasil.'
                ],
                'value_tags' => [
                    'Autonomia arquitetural',
                    'Influência transversal',
                    'Modernização incremental',
                    'Capacitação de equipes'
                ]
            ],
            'en' => [
                'eyebrow' => 'ENGINEERING LEADERSHIP · ENTERPRISE ARCHITECTURE · AI',
                'hero_title' => 'Engineering leadership <em>beyond code.</em>',
                'hero_lead' => 'I architect resilient software, lead engineering teams, and turn complex business challenges into platforms built to evolve.',
                'aside_tag' => 'SOFTWARE / SYSTEMS / PEOPLE',
                'about_title' => 'Technology decisions that <em>move organizations forward.</em>',
                'about_paragraphs' => [
                    'My career connects hands-on software development, architecture and cross-team technical leadership. At Emccamp, I was the sole technical lead for Construction, AI and Back Office engineering groups, with up to 30 professionals collectively.',
                    'I designed the modernization of a mission-critical legacy platform, helped establish product-oriented delivery practices, and prototyped an enterprise AI assistant that contributed to the creation of a dedicated AI R&D team.',
                    'Earlier at Vox Populi, I helped establish a software engineering department, led a nine-person team and built integrated platforms supporting more than 100 field research teams across Brazil.'
                ],
                'value_tags' => [
                    'Architecture ownership',
                    'Cross-team influence',
                    'Incremental modernization',
                    'Engineering enablement'
                ]
            ],
            'es' => [
                'eyebrow' => 'LIDERAZGO DE INGENIERÍA · ARQUITECTURA EMPRESARIAL · IA',
                'hero_title' => 'Liderazgo de ingeniería <em>más allá del código.</em>',
                'hero_lead' => 'Diseño software resiliente, lidero equipos de ingeniería y transformo desafíos complejos de negocio en plataformas preparadas para evolucionar.',
                'aside_tag' => 'SOFTWARE / SISTEMAS / PERSONAS',
                'about_title' => 'Decisiones técnicas que <em>impulsan organizaciones.</em>',
                'about_paragraphs' => [
                    'Mi trayectoria conecta el desarrollo práctico, la arquitectura de software y el liderazgo técnico transversal. En Emccamp, fui el único líder técnico de los equipos de Obras, IA y Backoffice, reuniendo hasta 30 profesionales.',
                    'Diseñé la modernización de una plataforma corporativa crítica, ayudé a establecer prácticas de entrega orientadas a producto y creé un prototipo de agente de IA que contribuyó a fundar el equipo dedicado de I+D en IA.',
                    'Anteriormente, en Vox Populi, ayudé a estructurar el departamento de desarrollo, lideré a nueve profesionales y construí plataformas integradas para más de 100 equipos de investigación de campo en Brasil.'
                ],
                'value_tags' => [
                    'Autoridad arquitectónica',
                    'Influencia transversal',
                    'Modernización incremental',
                    'Habilitación de equipos'
                ]
            ]
        ];

        $metrics = [
            [
                'value' => '20+',
                'label' => [
                    'pt' => 'anos em software',
                    'en' => 'years in software',
                    'es' => 'años en software'
                ]
            ],
            [
                'value' => '3',
                'label' => [
                    'pt' => 'equipes sob liderança técnica',
                    'en' => 'engineering groups led',
                    'es' => 'equipos bajo liderazgo técnico'
                ]
            ],
            [
                'value' => '40k+',
                'label' => [
                    'pt' => 'contratos nas plataformas atendidas',
                    'en' => 'contracts on supported platforms',
                    'es' => 'contratos en plataformas soportadas'
                ]
            ]
        ];

        $principles = [
            [
                'num' => '01',
                'title' => [
                    'pt' => 'Projetar para evoluir',
                    'en' => 'Design for change',
                    'es' => 'Diseñar para evolucionar'
                ],
                'desc' => [
                    'pt' => 'Preferir arquiteturas adaptáveis e migrações planejadas a substituições abruptas.',
                    'en' => 'Prefer evolvable architectures and deliberate migration paths over disruptive rewrites.',
                    'es' => 'Preferir arquitecturas adaptables y migraciones planificadas frente a reescrituras disruptivas.'
                ]
            ],
            [
                'num' => '02',
                'title' => [
                    'pt' => 'Assumir os trade-offs',
                    'en' => 'Own the trade-offs',
                    'es' => 'Asumir los trade-offs'
                ],
                'desc' => [
                    'pt' => 'Equilibrar qualidade técnica com segurança, custos e restrições legais e organizacionais.',
                    'en' => 'Balance technical quality with security, budget, legal and organizational constraints.',
                    'es' => 'Equilibrar la calidad técnica con la seguridad, presupuesto y restricciones legales y organizacionales.'
                ]
            ],
            [
                'num' => '03',
                'title' => [
                    'pt' => 'Potencializar equipes',
                    'en' => 'Enable other engineers',
                    'es' => 'Potenciar a los equipos'
                ],
                'desc' => [
                    'pt' => 'Criar ferramentas reutilizáveis, padrões e ciclos de feedback que apoiem os desenvolvedores.',
                    'en' => 'Build reusable tools, standards and feedback loops that make teams more effective.',
                    'es' => 'Crear herramientas reutilizables, estándares y ciclos de retroalimentación que hagan a los equipos más efectivos.'
                ]
            ]
        ];

        $languages = [
            'pt' => 'Português (nativo) · Inglês (fluente) · Espanhol (básico)',
            'en' => 'Portuguese (native) · English (fluent) · Spanish (basic)',
            'es' => 'Portugués (nativo) · Inglés (fluido) · Español (básico)'
        ];

        $resumes = [
            [
                'lang' => 'en',
                'label' => 'English PDF ↓',
                'url' => 'assets/resume/Alex_Reis_Resume_EN_Portfolio_v9.pdf'
            ],
            [
                'lang' => 'pt',
                'label' => 'Português PDF ↓',
                'url' => 'assets/resume/Alex_Reis_Curriculo_PT_Portfolio_v9.pdf'
            ]
        ];

        Model::query("DELETE FROM profile_settings");
        Model::query(
            "INSERT INTO profile_settings (
                full_name, short_name, brand_mark,
                role_subtitle_pt, role_subtitle_en, role_subtitle_es,
                location_pt, location_en, location_es,
                email, phone, whatsapp_url, github_url, linkedin_url, website_url,
                availability_pt, availability_en, availability_es,
                summary_json, metrics_json, principles_json, languages_json, resumes_json
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                'Alex de Oliveira Reis',
                'Alex Reis',
                'ar',
                'ENGENHARIA / LIDERANÇA',
                'ENGINEERING / LEADERSHIP',
                'INGENIERÍA / LIDERAZGO',
                'BELO HORIZONTE · MG · BRASIL',
                'BELO HORIZONTE · BRAZIL',
                'BELO HORIZONTE · BRASIL',
                'alex@opn1.net',
                '+55 (31) 99609-6037',
                'https://wa.me/5531996096037?text=Ol%C3%A1%2C+Alex%21+Vi+seu+portf%C3%B3lio.',
                'https://github.com/alex-o-reis',
                '',
                'https://alexreis.me',
                'Disponível para trabalho remoto, híbrido ou presencial e para viagens. Referências disponíveis mediante solicitação.',
                'Open to remote, hybrid or on-site roles and available to travel. References available upon request.',
                'Disponible para trabajo remoto, híbrido o presencial y disponibilidad para viajar. Referencias disponibles bajo solicitud.',
                $this->j($summary),
                $this->j($metrics),
                $this->j($principles),
                $this->j($languages),
                $this->j($resumes)
            ]
        );
        echo "  -> Profile settings populado com sucesso.\n";
    }

    private function seedExperiences(): void
    {
        $items = [
            [
                'company' => 'Emccamp Residencial',
                'period_pt' => 'SET/2020 — ATUAL',
                'period_en' => 'SEP/2020 — PRESENT',
                'period_es' => 'SEP/2020 — ACTUAL',
                'start_date' => '2020-09',
                'end_date' => null,
                'is_current' => 1,
                'role_pt' => 'Tech Lead (mai/2025–atual) · Analista/Desenvolvedor de Sistemas (set/2020–mai/2025)',
                'role_en' => 'Technical Lead (May 2025–present) · Systems Analyst / Developer (Sep 2020–May 2025)',
                'role_es' => 'Tech Lead (may/2025–actual) · Analista/Desarrollador de Sistemas (sep/2020–may/2025)',
                'desc_pt' => 'Único líder técnico de três grupos de engenharia (Obras, IA e Backoffice, até 30 profissionais), definindo arquitetura, padrões, integrações, revisões de código e governança dentro das restrições corporativas de TI, segurança e infraestrutura. Atuação prévia no desenvolvimento web (.NET Core, Silverlight), mobile (Android), serviços REST/SOAP e processos/adapters para BPM (Fusion – Java).',
                'desc_en' => 'Sole technical lead across three engineering groups (Construction, AI and Back Office, up to 30 professionals), defining architecture, engineering standards, integrations, code review and governance within corporate IT, security and infrastructure constraints. Prior hands-on delivery across web (.NET Core, Silverlight), mobile (Android), REST/SOAP services and BPM processes/adapters (Fusion – Java).',
                'desc_es' => 'Único líder técnico de tres grupos de ingeniería (Obras, IA y Backoffice, hasta 30 profesionales), definiendo arquitectura, estándares, integraciones, revisión de código y gobernanza dentro de restricciones corporativas de TI y seguridad. Experiencia previa en desarrollo web (.NET Core, Silverlight), móvil (Android), servicios REST/SOAP y procesos/adapters BPM (Fusion – Java).',
                'tags' => [
                    'pt' => ['Obras', 'IA', 'Backoffice', 'Azure', 'C# / .NET', 'BPM (Fusion/Java)', 'Android'],
                    'en' => ['Construction', 'AI', 'Back Office', 'Azure', 'C# / .NET', 'BPM (Fusion/Java)', 'Android'],
                    'es' => ['Obras', 'IA', 'Backoffice', 'Azure', 'C# / .NET', 'BPM (Fusion/Java)', 'Android']
                ],
                'order' => 1
            ],
            [
                'company' => 'Grupo SFA',
                'period_pt' => 'MAI/2019 — AGO/2019',
                'period_en' => 'MAY/2019 — AUG/2019',
                'period_es' => 'MAY/2019 — AGO/2019',
                'start_date' => '2019-05',
                'end_date' => '2019-08',
                'is_current' => 0,
                'role_pt' => 'Desenvolvedor de Sistemas',
                'role_en' => 'Software Developer',
                'role_es' => 'Desarrollador de Sistemas',
                'desc_pt' => 'Desenvolvimento de aplicativos mobile (Android e Flutter), aplicações web (Java, JPA e Angular) e serviços corporativos REST/SOAP em Java.',
                'desc_en' => 'Development of mobile applications (Android and Flutter), web systems (Java, JPA and Angular) and enterprise REST/SOAP services in Java.',
                'desc_es' => 'Desarrollo de aplicaciones móviles (Android y Flutter), sistemas web (Java, JPA y Angular) y servicios corporativos REST/SOAP en Java.',
                'tags' => [
                    'pt' => ['Android', 'Flutter', 'Java / JPA', 'Angular', 'REST / SOAP'],
                    'en' => ['Android', 'Flutter', 'Java / JPA', 'Angular', 'REST / SOAP'],
                    'es' => ['Android', 'Flutter', 'Java / JPA', 'Angular', 'REST / SOAP']
                ],
                'order' => 2
            ],
            [
                'company' => 'Biomtech Facial Recognition Solutions',
                'period_pt' => 'OUT/2018 — MAI/2019',
                'period_en' => 'OCT/2018 — MAY/2019',
                'period_es' => 'OCT/2018 — MAY/2019',
                'start_date' => '2018-10',
                'end_date' => '2019-05',
                'is_current' => 0,
                'role_pt' => 'Analista de Desenvolvimento Pleno II',
                'role_en' => 'Mid-level Systems Analyst II',
                'role_es' => 'Analista de Desarrollo Pleno II',
                'desc_pt' => 'Desenvolvimento de soluções de reconhecimento facial, incluindo o sistema FaceJus para o TJMG e o produto FaceSchool para escolas municipais (Android, iOS e Web).',
                'desc_en' => 'Development of facial recognition products, including the FaceJus platform for the Minas Gerais State Court (TJMG) and the FaceSchool product for municipal schools (Android, iOS and Web).',
                'desc_es' => 'Desarrollo de soluciones de reconocimiento facial, incluyendo el sistema FaceJus para el TJMG y el producto FaceSchool para escuelas municipales (Android, iOS y Web).',
                'tags' => [
                    'pt' => ['Reconhecimento Facial', 'FaceJus (TJMG)', 'FaceSchool', 'Android / iOS / Web'],
                    'en' => ['Facial Recognition', 'FaceJus (TJMG)', 'FaceSchool', 'Android / iOS / Web'],
                    'es' => ['Reconocimiento Facial', 'FaceJus (TJMG)', 'FaceSchool', 'Android / iOS / Web']
                ],
                'order' => 3
            ],
            [
                'company' => 'Std¹ DS + TI',
                'period_pt' => 'OUT/2017 — MAI/2018',
                'period_en' => 'OCT/2017 — MAY/2018',
                'period_es' => 'OCT/2017 — MAY/2018',
                'start_date' => '2017-10',
                'end_date' => '2018-05',
                'is_current' => 0,
                'role_pt' => 'Programador',
                'role_en' => 'Software Programmer',
                'role_es' => 'Programador',
                'desc_pt' => 'Desenvolvimento de sistemas especializados para o mercado de irrigação agrícola e criação de sites e portais web.',
                'desc_en' => 'Development of specialized software systems for the agricultural irrigation market and corporate websites.',
                'desc_es' => 'Desarrollo de sistemas especializados para el mercado de riego agrícola y sitios web corporativos.',
                'tags' => [
                    'pt' => ['Sistemas de Irrigação', 'Web', 'APIs'],
                    'en' => ['Irrigation Systems', 'Web', 'APIs'],
                    'es' => ['Sistemas de Riego', 'Web', 'APIs']
                ],
                'order' => 4
            ],
            [
                'company' => 'Vox Populi',
                'period_pt' => 'JAN/2003 — MAI/2016',
                'period_en' => 'JAN/2003 — MAY/2016',
                'period_es' => 'ENE/2003 — MAY/2016',
                'start_date' => '2003-01',
                'end_date' => '2016-05',
                'is_current' => 0,
                'role_pt' => 'Gerente de Projetos (set/2005–mai/2016) · Desenvolvedor (jan/2003–mai/2016)',
                'role_en' => 'Project Manager (Sep 2005–May 2016) · Software Developer (Jan 2003–May 2016)',
                'role_es' => 'Gerente de Proyectos (sep/2005–may/2016) · Desarrollador (ene/2003–may/2016)',
                'desc_pt' => 'Evoluiu de desenvolvedor freelancer à implantação do setor formal de desenvolvimento e gestão do departamento. Liderou equipe de nove profissionais (desenvolvimento, suporte e processamento de dados), conduziu implantação de BPM/ERP, BI, bancos de dados e estruturação para ISO, atendendo mais de 100 equipes de pesquisa no Brasil e projetos na América Latina.',
                'desc_en' => 'Progressed from freelance developer to establishing the formal software engineering department and managing nine professionals across development, support and data processing. Led BPM/ERP rollout, BI, database optimization and ISO technology readiness, supporting 100+ field research teams across Brazil and Latin America.',
                'desc_es' => 'Evolucionó de desarrollador freelance a la creación del área formal de desarrollo y gestión de nueve profesionales en desarrollo, soporte y procesamiento de datos. Lideró la implantación de BPM/ERP, BI, bases de datos y adecuación tecnológica para ISO, dando soporte a más de 100 equipos de investigación en Brasil y Latinoamérica.',
                'tags' => [
                    'pt' => ['Orion', 'REST', 'Automação de Dados', 'BPM / ERP', 'BI', 'ISO', 'Pesquisa'],
                    'en' => ['Orion', 'REST', 'Data Automation', 'BPM / ERP', 'BI', 'ISO', 'Research'],
                    'es' => ['Orion', 'REST', 'Automatización de Datos', 'BPM / ERP', 'BI', 'ISO', 'Investigación']
                ],
                'order' => 5
            ],
            [
                'company' => 'Wi3 Webdesign',
                'period_pt' => 'MAI/1999 — DEZ/2004',
                'period_en' => 'MAY/1999 — DEC/2004',
                'period_es' => 'MAY/1999 — DIC/2004',
                'start_date' => '1999-05',
                'end_date' => '2004-12',
                'is_current' => 0,
                'role_pt' => 'Programador / Webdesigner / Sócio',
                'role_en' => 'Programmer / Web Designer / Partner',
                'role_es' => 'Programador / Diseñador Web / Socio',
                'desc_pt' => 'Co-fundação e atuação técnica no desenvolvimento de sites institucionais, lojas virtuais e aplicações web sob medida.',
                'desc_en' => 'Partner and hands-on developer building corporate websites, e-commerce platforms and custom web applications.',
                'desc_es' => 'Socio y desarrollador en la creación de sitios web corporativos, tiendas virtuales y aplicaciones web a medida.',
                'tags' => [
                    'pt' => ['Sócio', 'Sites & Sistemas Web', 'PHP', 'E-commerce'],
                    'en' => ['Partner', 'Websites & Web Apps', 'PHP', 'E-commerce'],
                    'es' => ['Socio', 'Sitios y Sistemas Web', 'PHP', 'E-commerce']
                ],
                'order' => 6
            ]
        ];

        Model::query("DELETE FROM experiences");
        foreach ($items as $it) {
            Model::query(
                "INSERT INTO experiences (
                    company, period_label_pt, period_label_en, period_label_es,
                    start_date, end_date, is_current,
                    role_pt, role_en, role_es,
                    description_pt, description_en, description_es,
                    tags_json, display_order, is_visible
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)",
                [
                    $it['company'], $it['period_pt'], $it['period_en'], $it['period_es'],
                    $it['start_date'], $it['end_date'], $it['is_current'],
                    $it['role_pt'], $it['role_en'], $it['role_es'],
                    $it['desc_pt'], $it['desc_en'], $it['desc_es'],
                    $this->j($it['tags']), $it['order']
                ]
            );
        }
        echo "  -> " . count($items) . " experiencias populadas com sucesso.\n";
    }

    private function seedSkills(): void
    {
        $cats = [
            'architecture' => ['pt' => 'Arquitetura & BPM', 'en' => 'Architecture & BPM', 'es' => 'Arquitectura y BPM'],
            'backend'      => ['pt' => 'Back-end & APIs', 'en' => 'Back-end & APIs', 'es' => 'Back-end y APIs'],
            'frontend'     => ['pt' => 'Front-end', 'en' => 'Front-end', 'es' => 'Front-end'],
            'mobile'       => ['pt' => 'Mobile', 'en' => 'Mobile', 'es' => 'Móvil'],
            'data'         => ['pt' => 'Dados & Cloud', 'en' => 'Data & Cloud', 'es' => 'Datos y Cloud'],
            'ai'           => ['pt' => 'IA Aplicada', 'en' => 'Applied AI', 'es' => 'IA Aplicada'],
            'practices'    => ['pt' => 'Práticas & Liderança', 'en' => 'Practices & Leadership', 'es' => 'Prácticas y Liderazgo'],
        ];

        $skills = [
            ['architecture', 'Arquiteturas distribuídas', 'Distributed architectures', 'Arquitecturas distribuidas'],
            ['architecture', 'Microsserviços & Eventos', 'Microservices & Events', 'Microservicios y Eventos'],
            ['architecture', 'Modernização de legados', 'Legacy modernization', 'Modernización de legados'],
            ['architecture', 'BPM / Fusion / BPMN 2.0', 'BPM / Fusion / BPMN 2.0', 'BPM / Fusion / BPMN 2.0'],
            ['architecture', 'Integrações corporativas', 'Enterprise integrations', 'Integraciones empresariales'],

            ['backend', 'C# / .NET Core', 'C# / .NET Core', 'C# / .NET Core'],
            ['backend', 'PHP', 'PHP', 'PHP'],
            ['backend', 'Java / JPA', 'Java / JPA', 'Java / JPA'],
            ['backend', 'Python', 'Python', 'Python'],
            ['backend', 'APIs REST / SOAP', 'REST / SOAP APIs', 'APIs REST / SOAP'],
            ['backend', 'Mensageria', 'Messaging', 'Mensajería'],

            ['frontend', 'JavaScript (ES6+)', 'JavaScript (ES6+)', 'JavaScript (ES6+)'],
            ['frontend', 'HTML5 / CSS3 / Bootstrap', 'HTML5 / CSS3 / Bootstrap', 'HTML5 / CSS3 / Bootstrap'],
            ['frontend', 'Angular / SPA', 'Angular / SPA', 'Angular / SPA'],

            ['mobile', 'Android (Kotlin / Java)', 'Android (Kotlin / Java)', 'Android (Kotlin / Java)'],
            ['mobile', 'Flutter', 'Flutter', 'Flutter'],

            ['data', 'Microsoft Azure', 'Microsoft Azure', 'Microsoft Azure'],
            ['data', 'SQL Server / MySQL / Oracle', 'SQL Server / MySQL / Oracle', 'SQL Server / MySQL / Oracle'],
            ['data', 'SQLite', 'SQLite', 'SQLite'],
            ['data', 'Modelagem & Otimização SQL', 'Data Modeling & Optimization', 'Modelado y Optimización SQL'],

            ['ai', 'Microsoft Copilot & SharePoint', 'Microsoft Copilot & SharePoint', 'Microsoft Copilot y SharePoint'],
            ['ai', 'Orquestração de Agentes de IA', 'AI Agent Orchestration', 'Orquestación de Agentes de IA'],
            ['ai', 'Automação com IA', 'AI-Driven Automation', 'Automatización con IA'],

            ['practices', 'Revisão de código & Governança', 'Code Review & Governance', 'Revisión de código y Gobernanza'],
            ['practices', 'CI/CD & Observabilidade', 'CI/CD & Observability', 'CI/CD y Observabilidad'],
            ['practices', 'TDD', 'TDD', 'TDD'],
            ['practices', 'Scrum / Kanban', 'Scrum / Kanban', 'Scrum / Kanban'],
            ['practices', 'Liderança técnica & Mentoria', 'Technical Leadership & Mentoring', 'Liderazgo técnico y Mentoría'],
        ];

        Model::query("DELETE FROM skills");
        $order = 1;
        foreach ($skills as $s) {
            $c = $cats[$s[0]];
            Model::query(
                "INSERT INTO skills (
                    name_pt, name_en, name_es,
                    category_key, category_pt, category_en, category_es,
                    is_featured, display_order, is_visible
                ) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, 1)",
                [$s[1], $s[2], $s[3], $s[0], $c['pt'], $c['en'], $c['es'], $order++]
            );
        }
        echo "  -> " . count($skills) . " skills populadas com sucesso.\n";
    }

    private function seedEducation(): void
    {
        $items = [
            [
                'type' => 'degree',
                'institution' => 'PUC Minas',
                'title_pt' => 'Ciência da Computação',
                'title_en' => 'Computer Science',
                'title_es' => 'Ciencias de la Computación',
                'period' => '1998–2002',
                'details_pt' => 'Pontifícia Universidade Católica de Minas Gerais.',
                'details_en' => 'Pontifical Catholic University of Minas Gerais.',
                'details_es' => 'Pontificia Universidad Católica de Minas Gerais.',
                'order' => 1
            ],
            [
                'type' => 'degree',
                'institution' => 'UFMG',
                'title_pt' => 'Engenharia Civil (incompleto)',
                'title_en' => 'Civil Engineering (incomplete)',
                'title_es' => 'Ingeniería Civil (incompleto)',
                'period' => '2004–2005',
                'details_pt' => 'Cursado com foco em disciplinas de Meio Ambiente e Geoprocessamento.',
                'details_en' => 'Studied with focus on Environment and Geoprocessing coursework.',
                'details_es' => 'Cursado con enfoque en materias de Medio Ambiente y Geoprocesamiento.',
                'order' => 2
            ],
            [
                'type' => 'course',
                'institution' => 'Neomind',
                'title_pt' => 'Fusion BPM',
                'title_en' => 'Fusion BPM',
                'title_es' => 'Fusion BPM',
                'period' => '',
                'details_pt' => 'Modelagem, automação de processos e desenvolvimento de adapters.',
                'details_en' => 'Process modeling, automation and custom adapter development.',
                'details_es' => 'Modelado, automatización de procesos y desarrollo de adapters.',
                'order' => 3
            ],
            [
                'type' => 'course',
                'institution' => 'UFMG',
                'title_pt' => 'Sistemas Distribuídos',
                'title_en' => 'Distributed Systems',
                'title_es' => 'Sistemas Distribuidos',
                'period' => '',
                'details_pt' => 'Arquitetura, concorrência e escalabilidade em sistemas distribuídos.',
                'details_en' => 'Architecture, concurrency and scalability in distributed systems.',
                'details_es' => 'Arquitectura, concurrencia y escalabilidad en sistemas distribuidos.',
                'order' => 4
            ],
            [
                'type' => 'course',
                'institution' => 'UFMG',
                'title_pt' => 'Métodos Ágeis de Desenvolvimento',
                'title_en' => 'Agile Software Development Methods',
                'title_es' => 'Métodos Ágiles de Desarrollo',
                'period' => '',
                'details_pt' => 'Gestão ágil de equipes, Scrum e entrega contínua.',
                'details_en' => 'Agile team management, Scrum and iterative delivery.',
                'details_es' => 'Gestión ágil de equipos, Scrum y entrega continua.',
                'order' => 5
            ],
            [
                'type' => 'course',
                'institution' => 'Framework System',
                'title_pt' => 'Desenvolvimento de Aplicativos Android',
                'title_en' => 'Android Application Development',
                'title_es' => 'Desarrollo de Aplicaciones Android',
                'period' => '',
                'details_pt' => 'Desenvolvimento nativo mobile para dispositivos Android.',
                'details_en' => 'Native mobile development for Android devices.',
                'details_es' => 'Desarrollo móvil nativo para dispositivos Android.',
                'order' => 6
            ],
            [
                'type' => 'course',
                'institution' => 'DA Computação / PUC-MG',
                'title_pt' => 'Redes Ad-hoc',
                'title_en' => 'Ad-hoc Networks',
                'title_es' => 'Redes Ad-hoc',
                'period' => '',
                'details_pt' => 'Protocolos e topologias de redes descentralizadas.',
                'details_en' => 'Protocols and topologies for decentralized networks.',
                'details_es' => 'Protocolos y topologías de redes descentralizadas.',
                'order' => 7
            ],
            [
                'type' => 'course',
                'institution' => 'Code School',
                'title_pt' => 'Shaping Up with AngularJS',
                'title_en' => 'Shaping Up with AngularJS',
                'title_es' => 'Shaping Up with AngularJS',
                'period' => '',
                'details_pt' => 'Arquitetura SPA e componentes front-end.',
                'details_en' => 'SPA architecture and front-end components.',
                'details_es' => 'Arquitectura SPA y componentes front-end.',
                'order' => 8
            ]
        ];

        Model::query("DELETE FROM education_items");
        foreach ($items as $it) {
            Model::query(
                "INSERT INTO education_items (
                    item_type, institution,
                    title_pt, title_en, title_es,
                    period_label, details_pt, details_en, details_es,
                    display_order, is_visible
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)",
                [
                    $it['type'], $it['institution'],
                    $it['title_pt'], $it['title_en'], $it['title_es'],
                    $it['period'], $it['details_pt'], $it['details_en'], $it['details_es'],
                    $it['order']
                ]
            );
        }
        echo "  -> " . count($items) . " itens de formacao e cursos populados com sucesso.\n";
    }

    private function seedProjects(): void
    {
        $satwaDetailPt = [
            'eyebrow' => 'Plataforma SaaS em desenvolvimento',
            'headline' => 'SATWA — Clareza para gerir. <em>Liberdade para evoluir.</em>',
            'lead' => 'Chega de viver entre cinco ferramentas que não se conversam, horas duplicadas e planejamentos que não cabem no dia.',
            'sublead' => 'Uma plataforma construída em torno de quem realmente faz acontecer: você.',
            'bar_title' => 'BPMN 2.0 + CRM + SCRUM + KANBAN',
            'bar_subtitle' => 'Uma só tarefa. Todos os seus contextos. Sem duplicação.',
            'intro_eyebrow' => 'Por que SATWA',
            'intro_title' => 'Trabalho integrado de verdade.',
            'intro_text' => 'Projetos, tarefas, processos BPM, relacionamento com clientes e rotina pessoal compartilham uma unidade de trabalho comum. A plataforma integra Scrum, Kanban, CRM e BPMN 2.0 sem multiplicar cartões, históricos ou horas.',
            'features' => [
                ['code' => '01 / TAREFA UNIVERSAL', 'title' => 'Uma tarefa, vários mundos', 'desc' => 'A mesma atividade pode participar de projetos, quadros, sprints, processos e contextos pessoais, mantendo histórico e apontamentos únicos.'],
                ['code' => '02 / CAPACIDADE & PRIVACIDADE', 'title' => 'Capacidade real, privacidade preservada', 'desc' => 'Planeje usando jornadas, férias e compromissos externos; o impacto na agenda é considerado sem expor detalhes privados entre organizações.'],
                ['code' => '03 / APONTAMENTO DE TEMPO', 'title' => 'Um cronômetro global', 'desc' => 'Ao começar outra atividade, a anterior pausa. Separe esforço próprio e horas consolidadas das subtarefas, sem contagem em duplicidade.'],
                ['code' => '04 / SCRUM', 'title' => 'Sprints e Planning Poker nativos', 'desc' => 'Estime Story Points e horas independentemente, acompanhe a carga de trabalho e receba sugestões assistidas de alocação, com aprovação humana.'],
                ['code' => '05 / BPMN + CRM', 'title' => 'BPMN 2.0 e CRM no mesmo fluxo', 'desc' => 'Modele processos com piscinas, raias, decisões e prazos, ligados a tarefas e atendimentos. Organize contatos corporativos e pessoais no contexto certo.'],
                ['code' => '06 / VISÕES FLEXÍVEIS', 'title' => 'Seu trabalho, no seu formato', 'desc' => 'Kanban, lista, carga de trabalho, hierarquia e sprints, com os mesmos dados e sem perder contexto entre as visões.'],
                ['code' => '07 / GOVERNANÇA', 'title' => 'Competências e governança', 'desc' => 'Qualificações e certificações com alertas, permissões configuráveis, exceções auditáveis e histórico de alterações.'],
                ['code' => '08 / CONTROLE HUMANO', 'title' => 'Automação que respeita decisões humanas', 'desc' => 'Alocação assistida, recomendações e fluxos de aprovação apoiam a equipe sem retirar sua autonomia.']
            ],
            'pillars_eyebrow' => 'O coração do produto',
            'pillars_title' => 'Uma base de trabalho. Três disciplinas conectadas.',
            'pillars' => [
                ['title' => 'SCRUM + KANBAN', 'desc' => 'Planejamento de sprints, execução visual, estimativas, priorização e capacidade de equipe.'],
                ['title' => 'BPMN 2.0', 'desc' => 'Fluxos, atividades, decisões, prazos e responsáveis conectados às tarefas.'],
                ['title' => 'CRM', 'desc' => 'Contatos, oportunidades e atendimentos vinculados ao trabalho e aos processos.']
            ],
            'disclaimer' => 'SATWA está em desenvolvimento. Os recursos descritos representam a visão e o escopo planejado, não uma declaração de disponibilidade comercial.'
        ];

        $satwaDetailEn = [
            'eyebrow' => 'SaaS platform in development',
            'headline' => 'SATWA — Clarity to manage. <em>Freedom to evolve.</em>',
            'lead' => 'Stop juggling disconnected tools, duplicated time logs and plans that never fit your actual day.',
            'sublead' => 'A platform designed around the person who actually gets work done: you.',
            'bar_title' => 'BPMN 2.0 + CRM + SCRUM + KANBAN',
            'bar_subtitle' => 'One task. Every context. No duplicated work.',
            'intro_eyebrow' => 'Why SATWA',
            'intro_title' => 'Work that is truly connected.',
            'intro_text' => 'Projects, tasks, BPM workflows, customer relationships and personal routines share a common work unit. Scrum, Kanban, CRM and BPMN 2.0 connect without duplicated cards, histories or time entries.',
            'features' => [
                ['code' => '01 / UNIVERSAL TASK', 'title' => 'One task across many worlds', 'desc' => 'A task can belong to projects, boards, sprints, processes and personal contexts while keeping one history and one time record.'],
                ['code' => '02 / CAPACITY & PRIVACY', 'title' => 'Real capacity, private by design', 'desc' => 'Plan with variable schedules, time off and external commitments; capacity is considered without revealing private details across organizations.'],
                ['code' => '03 / TIME TRACKING', 'title' => 'One global timer', 'desc' => 'Starting another task pauses the prior timer. Track direct effort separately from consolidated subtask hours, without double counting.'],
                ['code' => '04 / SCRUM', 'title' => 'Native sprints and Planning Poker', 'desc' => 'Estimate Story Points and hours independently, see workload and receive assisted allocation suggestions with human approval.'],
                ['code' => '05 / BPMN + CRM', 'title' => 'BPMN 2.0 and CRM in one flow', 'desc' => 'Model pools, lanes, decisions and deadlines connected to tasks and CRM cases. Manage business and personal contacts in the right context.'],
                ['code' => '06 / FLEXIBLE VIEWS', 'title' => 'Your work, your preferred view', 'desc' => 'Kanban, list, workload, hierarchy and sprint views on the same data, without losing context when switching views.'],
                ['code' => '07 / GOVERNANCE', 'title' => 'Skills and governance', 'desc' => 'Skills and certifications with alerts, configurable permissions, auditable exceptions and change history.'],
                ['code' => '08 / HUMAN-CENTERED', 'title' => 'Automation with human control', 'desc' => 'Assisted staffing, recommendations and approval flows support teams without replacing human judgement.']
            ],
            'pillars_eyebrow' => 'At the core of the product',
            'pillars_title' => 'One work platform. Three connected disciplines.',
            'pillars' => [
                ['title' => 'SCRUM + KANBAN', 'desc' => 'Sprint planning, visual execution, estimates, prioritization and team capacity.'],
                ['title' => 'BPMN 2.0', 'desc' => 'Flows, activities, decisions, deadlines and ownership connected to tasks.'],
                ['title' => 'CRM', 'desc' => 'Contacts, opportunities and cases connected to actual work and processes.']
            ],
            'disclaimer' => 'SATWA is in development. Described capabilities reflect product vision and planned scope, not currently available commercial features.'
        ];

        $satwaDetailEs = [
            'eyebrow' => 'Plataforma SaaS en desarrollo',
            'headline' => 'SATWA — Claridad para gestionar. <em>Libertad para evolucionar.</em>',
            'lead' => 'Basta de alternar entre cinco herramientas desconectadas, horas duplicadas y planes que nunca caben en el día.',
            'sublead' => 'Una plataforma pensada alrededor de quien realmente hace que el trabajo suceda: tú.',
            'bar_title' => 'BPMN 2.0 + CRM + SCRUM + KANBAN',
            'bar_subtitle' => 'Una sola tarea. Todos tus contextos. Sin duplicación.',
            'intro_eyebrow' => 'Por qué SATWA',
            'intro_title' => 'Trabajo conectado de verdad.',
            'intro_text' => 'Proyectos, tareas, procesos BPM, relación con clientes y rutina personal comparten una misma unidad de trabajo. Scrum, Kanban, CRM y BPMN 2.0 se conectan sin duplicar tarjetas, historiales ni registros de horas.',
            'features' => [
                ['code' => '01 / TAREA UNIVERSAL', 'title' => 'Una tarea, múltiples contextos', 'desc' => 'Una misma actividad puede participar en proyectos, tableros, sprints, procesos y contextos personales con un solo historial y registro de tiempo.'],
                ['code' => '02 / CAPACIDAD Y PRIVACIDAD', 'title' => 'Capacidad real con privacidad', 'desc' => 'Planifica considerando jornadas, vacaciones y compromisos externos sin exponer detalles privados entre organizaciones.'],
                ['code' => '03 / REGISTRO DE TIEMPO', 'title' => 'Un cronómetro global', 'desc' => 'Al iniciar otra tarea, la anterior se pausa. Separa el esfuerzo directo de las horas consolidadas de subtareas sin doble conteo.'],
                ['code' => '04 / SCRUM', 'title' => 'Sprints y Planning Poker nativos', 'desc' => 'Estima Story Points y horas por separado, visualiza la carga y recibe sugerencias asistidas de asignación con aprobación humana.'],
                ['code' => '05 / BPMN + CRM', 'title' => 'BPMN 2.0 y CRM en un solo flujo', 'desc' => 'Modela pools, carriles, decisiones y plazos conectados a tareas y casos CRM en el contexto adecuado.'],
                ['code' => '06 / VISTAS FLEXIBLES', 'title' => 'Tu trabajo en tu formato', 'desc' => 'Vistas Kanban, lista, carga de trabajo, jerarquía y sprints sobre los mismos datos sin perder contexto.'],
                ['code' => '07 / GOBERNANZA', 'title' => 'Competencias y gobernanza', 'desc' => 'Habilidades y certificaciones con alertas, permisos configurables, excepciones auditables e historial de cambios.'],
                ['code' => '08 / CONTROL HUMANO', 'title' => 'Automatización bajo control humano', 'desc' => 'Recomendaciones y flujos de aprobación asisten al equipo sin reemplazar el criterio humano.']
            ],
            'pillars_eyebrow' => 'El corazón del producto',
            'pillars_title' => 'Una plataforma. Tres disciplinas conectadas.',
            'pillars' => [
                ['title' => 'SCRUM + KANBAN', 'desc' => 'Planificación de sprints, ejecución visual, estimaciones, priorización y capacidad del equipo.'],
                ['title' => 'BPMN 2.0', 'desc' => 'Flujos, actividades, decisiones, plazos y responsables conectados a las tareas.'],
                ['title' => 'CRM', 'desc' => 'Contactos, oportunidades y casos vinculados al trabajo real y a los procesos.']
            ],
            'disclaimer' => 'SATWA está en desarrollo. Las funcionalidades descritas reflejan la visión y el alcance planificado, no una promesa de disponibilidad comercial inmediata.'
        ];

        $krewwDetailPt = [
            'eyebrow' => 'Produto em desenvolvimento',
            'headline' => 'Kreww — <em>Sua equipe de agentes de IA.</em>',
            'lead' => 'Agentes especializados para apoiar, organizar e automatizar rotinas de negócios, com supervisão humana.',
            'sublead' => 'Orquestração de equipes digitais sob medida para atendimento, análise, operação e suporte empresarial.',
            'bar_title' => 'AGENTES ESPECIALIZADOS · CHECKPOINTS · RASTREABILIDADE',
            'bar_subtitle' => 'Da análise à execução com controle humano em cada etapa.',
            'intro_eyebrow' => 'Proposta do produto',
            'intro_title' => 'Equipes digitais coordenadas para o negócio.',
            'intro_text' => 'Kreww conecta agentes especializados em torno dos processos reais da empresa, unindo automação, aprovações explícitas e rastreabilidade completa.',
            'features' => [
                ['code' => '01 / EQUIPES DE IA', 'title' => 'Equipes de agentes especializados', 'desc' => 'Coordene agentes voltados a atendimento, análise, operação e suporte trabalhando em conjunto.'],
                ['code' => '02 / EXECUÇÃO', 'title' => 'Da análise à execução', 'desc' => 'Conecte descoberta, planejamento e rotinas operacionais em fluxos contínuos e integrados.'],
                ['code' => '03 / SUPERVISÃO HUMANA', 'title' => 'Governança e checkpoints', 'desc' => 'Preveja aprovação humana, rastreabilidade e controle sobre as ações executadas pelos agentes.']
            ],
            'disclaimer' => 'Apresentação conceitual de produto em desenvolvimento. As funcionalidades descritas representam objetivos de produto e não garantem disponibilidade comercial imediata.'
        ];

        $krewwDetailEn = [
            'eyebrow' => 'Product in development',
            'headline' => 'Kreww — <em>Your AI agent team.</em>',
            'lead' => 'Specialized agents to assist, organize and automate business routines with human oversight.',
            'sublead' => 'Tailored digital teams built for customer support, analysis, operations and business execution.',
            'bar_title' => 'SPECIALIZED AGENTS · CHECKPOINTS · TRACEABILITY',
            'bar_subtitle' => 'From analysis to execution with people firmly in control.',
            'intro_eyebrow' => 'Product vision',
            'intro_title' => 'Coordinated digital teams for real business workflows.',
            'intro_text' => 'Kreww orchestrates specialized AI agents around real company processes, combining automation with explicit approvals and end-to-end traceability.',
            'features' => [
                ['code' => '01 / AI AGENT TEAMS', 'title' => 'Specialized AI agent teams', 'desc' => 'Coordinate digital teams focused on support, analysis, operations and structured business tasks.'],
                ['code' => '02 / EXECUTION', 'title' => 'From analysis to action', 'desc' => 'Connect discovery, planning and operational workflows into unified automated pipelines.'],
                ['code' => '03 / HUMAN OVERSIGHT', 'title' => 'Governance & approval checkpoints', 'desc' => 'Build approval gates, traceability and supervision directly into agent routines.']
            ],
            'disclaimer' => 'Conceptual presentation of a product in development. Described capabilities represent product goals and do not imply current commercial availability.'
        ];

        $krewwDetailEs = [
            'eyebrow' => 'Producto en desarrollo',
            'headline' => 'Kreww — <em>Tu equipo de agentes de IA.</em>',
            'lead' => 'Agentes especializados para apoyar, organizar y automatizar rutinas empresariales con supervisión humana.',
            'sublead' => 'Orquestación de equipos digitales a medida para atención, análisis, operación y soporte.',
            'bar_title' => 'AGENTES ESPECIALIZADOS · CHECKPOINTS · TRAZABILIDAD',
            'bar_subtitle' => 'Del análisis a la ejecución con control humano en cada paso.',
            'intro_eyebrow' => 'Visión del producto',
            'intro_title' => 'Equipos digitales coordinados para procesos reales.',
            'intro_text' => 'Kreww coordina agentes especializados alrededor de los procesos de la empresa, combinando automatización, puntos de aprobación y trazabilidad completa.',
            'features' => [
                ['code' => '01 / EQUIPOS DE IA', 'title' => 'Equipos de agentes especializados', 'desc' => 'Coordina agentes enfocados en atención, análisis, operación y soporte empresarial.'],
                ['code' => '02 / EJECUCIÓN', 'title' => 'Del análisis a la acción', 'desc' => 'Conecta descubrimiento, planificación y rutinas operativas en flujos integrados.'],
                ['code' => '03 / SUPERVISIÓN HUMANA', 'title' => 'Gobernanza y aprobaciones', 'desc' => 'Incorpora puntos de aprobación, trazabilidad y control humano en las acciones de los agentes.']
            ],
            'disclaimer' => 'Presentación conceptual de un producto en desarrollo. Las capacidades descritas representan objetivos de producto y no garantizan disponibilidad comercial inmediata.'
        ];

        $controlDetailPt = [
            'eyebrow' => 'Estudo de Caso · Modernização de Legado',
            'headline' => 'ControlEmp — <em>Migração incremental sem parar a operação.</em>',
            'lead' => 'Substituição de uma plataforma crítica em Silverlight por arquitetura web distribuída e APIs REST em C#, preservando regras e banco compartilhado durante 12 meses de transição.',
            'challenge' => 'Garantir continuidade operacional enquanto se substituía um sistema crítico em Silverlight com dependência de Windows e atualizações manuais em centenas de máquinas.',
            'approach' => 'Operação paralela por 12 meses, retrocompatibilidade controlada, APIs REST em C#, revisão ativa de todo o código e homologação progressiva pelas áreas.',
            'features' => [
                ['code' => '01 / COEXISTÊNCIA', 'title' => 'Banco compartilhado e regras estáveis', 'desc' => 'Sincronização de exceções e compatibilidade com o sistema legado durante todo o período de migração.'],
                ['code' => '02 / ENTREGA CONTÍNUA', 'title' => 'Releases diários centralizados', 'desc' => 'Acesso via navegador eliminou a necessidade de atualizar estações de trabalho individualmente.'],
                ['code' => '03 / EXTENSIBILIDADE', 'title' => 'Base para APIs e aplicativos', 'desc' => 'Camada REST desacoplada abriu caminho para novas integrações corporativas e apps móveis.']
            ]
        ];

        $controlDetailEn = [
            'eyebrow' => 'Case Study · Legacy Modernization',
            'headline' => 'ControlEmp — <em>Incremental migration with zero downtime.</em>',
            'lead' => 'Replaced a mission-critical Silverlight application with a distributed browser-based platform and C# REST APIs, preserving shared data and business rules across a 12-month transition.',
            'challenge' => 'Maintain business continuity while replacing a critical Silverlight platform constrained to Windows workstations and manual client updates.',
            'approach' => '12-month parallel operation, controlled backward compatibility, C# REST APIs, active code review and progressive department-level acceptance.',
            'features' => [
                ['code' => '01 / COEXISTENCE', 'title' => 'Shared database & stable rules', 'desc' => 'Synchronized exceptions and full backward compatibility alongside the legacy application throughout migration.'],
                ['code' => '02 / CONTINUOUS DELIVERY', 'title' => 'Daily centralized releases', 'desc' => 'Browser-based access eliminated updating hundreds of workstations one by one.'],
                ['code' => '03 / EXTENSIBILITY', 'title' => 'Foundation for APIs & mobile', 'desc' => 'Decoupled REST services enabled new enterprise integrations and mobile applications.']
            ]
        ];

        $controlDetailEs = [
            'eyebrow' => 'Caso de Estudio · Modernización de Legado',
            'headline' => 'ControlEmp — <em>Migración incremental sin detener la operación.</em>',
            'lead' => 'Sustitución de una plataforma crítica en Silverlight por una arquitectura web distribuida y APIs REST en C#, preservando reglas y base compartida durante 12 meses.',
            'challenge' => 'Garantizar continuidad operativa al reemplazar un sistema crítico en Silverlight dependiente de Windows y actualizaciones en cientos de equipos.',
            'approach' => 'Operación paralela por 12 meses, retrocompatibilidad controlada, APIs REST en C#, revisión activa de código y homologación por áreas.',
            'features' => [
                ['code' => '01 / COEXISTENCIA', 'title' => 'Base compartida y reglas estables', 'desc' => 'Sincronización de excepciones y compatibilidad total con el sistema legado durante la transición.'],
                ['code' => '02 / ENTREGA CONTINUA', 'title' => 'Despliegues diarios centralizados', 'desc' => 'Acceso desde navegador eliminando instalaciones en cientos de estaciones de trabajo.'],
                ['code' => '03 / EXTENSIBILIDAD', 'title' => 'Base para APIs y aplicaciones', 'desc' => 'Servicios REST desacoplados habilitaron nuevas integraciones y apps móviles.']
            ]
        ];

        $koreDetailPt = [
            'eyebrow' => 'Open Source · Licença MIT',
            'headline' => 'Kore Framework — <em>Backend PHP REST + SPA desacoplada.</em>',
            'lead' => 'Framework modular open source criado para unir produtividade, isolamento estrito entre core e aplicação e renderização de UI desacoplada via UI Relay (Bootstrap 5).',
            'features' => [
                ['code' => '01 / BACKEND REST', 'title' => 'Router por Reflection e ORM com Traits', 'desc' => 'Suporte nativo a SQLite e MySQL, migrations, seeders, middlewares e Traits regeneráveis via CLI.'],
                ['code' => '02 / UI RELAY', 'title' => 'Frontend SPA sem HTML acoplado', 'desc' => 'Views em JavaScript usam UI.* despachado para Renderers intercambiáveis como BootstrapRenderer.'],
                ['code' => '03 / PRODUTIVIDADE', 'title' => 'CLI integrada e OpenAPI', 'desc' => 'Comandos kore dev, migrate, seed, make:models, routes e documentação Swagger automática.']
            ]
        ];

        $koreDetailEn = [
            'eyebrow' => 'Open Source · MIT License',
            'headline' => 'Kore Framework — <em>PHP REST Backend + Decoupled SPA.</em>',
            'lead' => 'Modular open-source framework built to combine rapid delivery, strict core/userspace isolation and decoupled UI rendering through UI Relay (Bootstrap 5).',
            'features' => [
                ['code' => '01 / REST BACKEND', 'title' => 'Reflection Router & Regenerable ORM Traits', 'desc' => 'Native SQLite & MySQL support, migrations, seeders, middlewares and CLI-regenerated ORM traits.'],
                ['code' => '02 / UI RELAY', 'title' => 'Decoupled SPA Rendering', 'desc' => 'JavaScript views compose interfaces via UI.* dispatched to swappable renderers like BootstrapRenderer.'],
                ['code' => '03 / DEVELOPER DX', 'title' => 'Built-in CLI & OpenAPI', 'desc' => 'Includes kore dev, migrate, seed, make:models, routes and automatic Swagger documentation.']
            ]
        ];

        $koreDetailEs = [
            'eyebrow' => 'Open Source · Licencia MIT',
            'headline' => 'Kore Framework — <em>Backend PHP REST + SPA desacoplada.</em>',
            'lead' => 'Framework modular open source creado para unir productividad, aislamiento estricto entre core y aplicación y renderizado desacoplado con UI Relay (Bootstrap 5).',
            'features' => [
                ['code' => '01 / BACKEND REST', 'title' => 'Router por Reflection y ORM con Traits', 'desc' => 'Soporte nativo para SQLite y MySQL, migraciones, seeders, middlewares y Traits regenerables por CLI.'],
                ['code' => '02 / UI RELAY', 'title' => 'Frontend SPA desacoplado', 'desc' => 'Las vistas usan UI.* despachado a Renderers intercambiables como BootstrapRenderer.'],
                ['code' => '03 / PRODUCTIVIDAD', 'title' => 'CLI integrada y OpenAPI', 'desc' => 'Comandos kore dev, migrate, seed, make:models, routes y documentación Swagger automática.']
            ]
        ];

        $projects = [
            // 1. ControlEmp (Case Study 01 + Detail)
            [
                'slug' => 'controlem',
                'name' => ['ControlEmp', 'ControlEmp', 'ControlEmp'],
                'category' => 'enterprise',
                'status' => 'delivered',
                'org' => ['Emccamp', 'Emccamp', 'Emccamp'],
                'stack' => ['C# · APIs REST · Arquitetura corporativa · Migração', 'C# · REST APIs · Enterprise architecture · Migration', 'C# · APIs REST · Arquitectura empresarial · Migración'],
                'summary' => [
                    'Modernização incremental da plataforma crítica de gestão de empreiteiros, de Silverlight para web distribuída e APIs REST. Coexistência por 12 meses com regras compatíveis, revisão de código e entregas diárias.',
                    'Incremental modernization of a mission-critical contractor platform from Silverlight to browser-based services and REST APIs, with parallel operation, controlled business rules and daily centralized deployment.',
                    'Modernización incremental de una plataforma crítica de gestión de contratistas, de Silverlight a web distribuida y APIs REST, con operación paralela por 12 meses y entregas diarias.'
                ],
                'has_detail' => 1,
                'detail' => [$controlDetailPt, $controlDetailEn, $controlDetailEs],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 1,
                'case_order' => 1,
                'case_label' => ['01 — MODERNIZAÇÃO DE LEGADO', '01 — LEGACY MODERNIZATION', '01 — MODERNIZACIÓN DE LEGADO'],
                'case_icon' => '↗',
                'order' => 1
            ],
            // 2. Viabiliza (Case Study 02)
            [
                'slug' => 'viabiliza',
                'name' => ['Viabiliza', 'Viabiliza', 'Viabiliza'],
                'category' => 'enterprise',
                'status' => 'delivered',
                'org' => ['Emccamp', 'Emccamp', 'Emccamp'],
                'stack' => ['Web · Workflow · API · Integração com IA', 'Web · Workflow · API · AI integration', 'Web · Workflow · API · Integración IA'],
                'summary' => [
                    'Plataforma de estudos de viabilidade de terrenos com contribuições assíncronas das diferentes áreas, reutilizando a base corporativa e integrando a captação automatizada pela equipe de IA.',
                    'Land feasibility platform coordinating asynchronous multi-department studies, reusing the corporate platform foundation and integrating AI-team land discovery automation.',
                    'Plataforma de estudios de viabilidad de terrenos con flujo asíncrono multidisciplinario, reutilizando la arquitectura corporativa e integrando captación automatizada con IA.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 1,
                'case_order' => 2,
                'case_label' => ['02 — PLATAFORMA DE WORKFLOW', '02 — WORKFLOW PLATFORM', '02 — PLATAFORMA DE WORKFLOW'],
                'case_icon' => '◎',
                'order' => 2
            ],
            // 3. Agente de conhecimento corporativo (Case Study 03)
            [
                'slug' => 'agente-conhecimento-ia',
                'name' => ['Agente de conhecimento corporativo', 'Enterprise knowledge assistant', 'Agente de conocimiento corporativo'],
                'category' => 'ai',
                'status' => 'delivered',
                'org' => ['Emccamp', 'Emccamp', 'Emccamp'],
                'stack' => ['Copilot · SharePoint · Gestão do conhecimento', 'Copilot · SharePoint · Knowledge management', 'Copilot · SharePoint · Gestión del conocimiento'],
                'summary' => [
                    'Protótipo proativo em Microsoft Copilot conectado ao SharePoint do setor de projetos. Tornou-se recurso interno e ajudou a fundamentar a criação da equipe de P&D em IA.',
                    'Proactive Microsoft Copilot assistant connected to Projects SharePoint documentation. The initiative became an internal resource and helped establish the company’s AI R&D team.',
                    'Prototipo proactivo en Microsoft Copilot conectado a la documentación de proyectos en SharePoint. Se convirtió en recurso interno y ayudó a crear el equipo de I+D en IA.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 1,
                'case_order' => 3,
                'case_label' => ['03 — IA CORPORATIVA', '03 — ENTERPRISE AI', '03 — IA CORPORATIVA'],
                'case_icon' => '✳',
                'order' => 3
            ],
            // 4. Framework corporativo (category: platform — now with dedicated filter!)
            [
                'slug' => 'framework-corporativo',
                'name' => ['Framework corporativo', 'Internal enterprise framework', 'Framework corporativo interno'],
                'category' => 'platform',
                'status' => 'delivered',
                'org' => ['Emccamp', 'Emccamp', 'Emccamp'],
                'stack' => ['C# · JavaScript · Componentes UI · APIs', 'C# · JavaScript · UI components · APIs', 'C# · JavaScript · Componentes UI · APIs'],
                'summary' => [
                    'Framework interno idealizado em aproximadamente dois meses: biblioteca UI reutilizável, SmartBox, padrões de front-end e comunicação centralizada com APIs.',
                    'Internal framework conceived over approximately two months: reusable UI components, SmartBox, front-end conventions and centralized API communication.',
                    'Framework interno diseñado en aproximadamente dos meses: biblioteca UI reutilizable, SmartBox, estándares de front-end y comunicación centralizada con APIs.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 4
            ],
            // 5. Orion (Case Study 04)
            [
                'slug' => 'orion',
                'name' => ['Orion', 'Orion', 'Orion'],
                'category' => 'enterprise',
                'status' => 'delivered',
                'org' => ['Vox Populi', 'Vox Populi', 'Vox Populi'],
                'stack' => ['REST · Sistemas de pesquisa · Dados', 'REST · Research systems · Data', 'REST · Sistemas de investigación · Datos'],
                'summary' => [
                    'Plataforma unificada que integrou ferramentas independentes de questionários, coleta, análise, relatórios e dashboards por meio de APIs REST e interface única.',
                    'Unified research platform integrating independent applications for questionnaires, data capture, analytics, reports and dashboards behind REST APIs and a single interface.',
                    'Plataforma unificada que integró herramientas de cuestionarios, recolección, análisis, reportes y dashboards mediante APIs REST y una interfaz única.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 1,
                'case_order' => 4,
                'case_label' => ['04 — CONSOLIDAÇÃO DE PLATAFORMA', '04 — PLATFORM CONSOLIDATION', '04 — CONSOLIDACIÓN DE PLATAFORMA'],
                'case_icon' => '⌘',
                'order' => 5
            ],
            // 6. Automação de relatórios LATAM
            [
                'slug' => 'relatorios-latam',
                'name' => ['Automação de relatórios LATAM', 'LATAM reporting automation', 'Automatización de reportes LATAM'],
                'category' => 'data',
                'status' => 'delivered',
                'org' => ['Vox Populi', 'Vox Populi', 'Vox Populi'],
                'stack' => ['Automação · Relatórios · Resposta a crises', 'Automation · Reporting · Crisis response', 'Automatización · Reportes · Respuesta a crisis'],
                'summary' => [
                    'Automação emergencial de dezenas de relatórios extensos em uma semana durante crise operacional de projeto latino-americano.',
                    'Emergency automation of dozens of extensive reports in one week during a critical Latin American research project.',
                    'Automatización de emergencia de decenas de reportes extensos en una semana durante una crisis operativa en un proyecto latinoamericano.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 6
            ],
            // 7. Georreferenciamento
            [
                'slug' => 'georreferenciamento',
                'name' => ['Georreferenciamento', 'Georeferencing platform', 'Georreferenciación'],
                'category' => 'data',
                'status' => 'delivered',
                'org' => ['Vox Populi', 'Vox Populi', 'Vox Populi'],
                'stack' => ['Geoprocessamento · Setor público', 'Geospatial · Public-sector systems', 'Geoprocesamiento · Sector público'],
                'summary' => [
                    'Solução iniciada em projeto para o Ministério do Desenvolvimento Social e posteriormente adaptada para produto destinado aos Correios.',
                    'Georeferencing solution initially created for a Ministry of Social Development project and later adapted for Correios.',
                    'Solución iniciada para el Ministerio de Desarrollo Social y adaptada posteriormente como producto para Correios.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 7
            ],
            // 8. Opn1.net
            [
                'slug' => 'opn1',
                'name' => ['Opn1.net', 'Opn1.net', 'Opn1.net'],
                'category' => 'product',
                'status' => 'evolving',
                'org' => ['Independente', 'Independent', 'Independiente'],
                'stack' => ['Pesquisa · Analytics · Mobile · Relatórios', 'Research · Analytics · Mobile · Reports', 'Investigación · Analytics · Móvil · Reportes'],
                'summary' => [
                    'Plataforma própria de pesquisas, criada inicialmente antes da Emccamp; aplicação e acompanhamento de campo, prévias, dashboards, relatórios e apresentações.',
                    'Independent survey platform first created before Emccamp, covering field execution and tracking, previews, dashboards, reporting and presentations.',
                    'Plataforma propia de encuestas creada antes de Emccamp, abarcando ejecución y seguimiento de campo, vistas previas, dashboards y reportes.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://opn1.net/',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 8
            ],
            // 9. Kore Framework (Open Source + Detail page + GitHub link)
            [
                'slug' => 'kore-framework',
                'name' => ['Kore Framework', 'Kore Framework', 'Kore Framework'],
                'category' => 'opensource',
                'status' => 'public',
                'org' => ['Kodey · Open Source', 'Kodey · Open Source', 'Kodey · Open Source'],
                'stack' => ['PHP · JavaScript · MVC · SQLite / MySQL', 'PHP · JavaScript · MVC · SQLite / MySQL', 'PHP · JavaScript · MVC · SQLite / MySQL'],
                'summary' => [
                    'Framework open source PHP/JavaScript com backend REST, SPA, ORM com traits regeneráveis, CLI e renderização de UI separada da lógica (base deste portfólio).',
                    'Open-source PHP/JavaScript framework with REST API, SPA, regenerable ORM traits, CLI tools and decoupled UI rendering (powering this portfolio).',
                    'Framework open source PHP/JavaScript con backend REST, SPA, ORM con traits regenerables, CLI y renderizado desacoplado (base de este portafolio).'
                ],
                'has_detail' => 1,
                'detail' => [$koreDetailPt, $koreDetailEn, $koreDetailEs],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://github.com/alex-o-reis/kore-framework/',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 9
            ],
            // 10. Lean App
            [
                'slug' => 'lean-app',
                'name' => ['Lean App', 'Lean App', 'Lean App'],
                'category' => 'product',
                'status' => 'development',
                'org' => ['Independente / cliente', 'Independent / client project', 'Independiente / cliente'],
                'stack' => ['Construção Lean · Kanban · Corporativo', 'Lean construction · Kanban · Enterprise', 'Construcción Lean · Kanban · Corporativo'],
                'summary' => [
                    'Plataforma de gestão Lean para obras: orçamento, planejamento, Kanban, cronogramas, diário de obra, inspeções, medições e indicadores.',
                    'Lean construction platform for budgeting, planning, Kanban, schedules, jobsite logs, inspections, measurement and KPIs.',
                    'Plataforma de gestión Lean para obras: presupuestos, planificación, Kanban, cronogramas, diario de obra, inspecciones e indicadores.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 10
            ],
            // 11. SATWA (Featured + Detail)
            [
                'slug' => 'satwa',
                'name' => ['SATWA', 'SATWA', 'SATWA'],
                'category' => 'product',
                'status' => 'development',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['SaaS · BPMN 2.0 · Scrum / Kanban · CRM', 'SaaS · BPMN 2.0 · Scrum / Kanban · CRM', 'SaaS · BPMN 2.0 · Scrum / Kanban · CRM'],
                'summary' => [
                    'Gestão de tarefas, equipes, processos BPMN 2.0, Scrum, Kanban, CRM e capacidade real em uma única plataforma.',
                    'Unified SaaS platform for tasks, teams, BPMN 2.0 workflows, Scrum, Kanban, CRM and real capacity management.',
                    'Gestión de tareas, equipos, procesos BPMN 2.0, Scrum, Kanban, CRM y capacidad real en una sola plataforma.'
                ],
                'has_detail' => 1,
                'detail' => [$satwaDetailPt, $satwaDetailEn, $satwaDetailEs],
                'cover' => 'assets/satwa-official-brand-crop.jpg',
                'theme' => 'satwa',
                'system_url' => null,
                'video_url' => null,
                'featured' => 1,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 11
            ],
            // 12. Kreww (Featured + Detail)
            [
                'slug' => 'kreww',
                'name' => ['Kreww', 'Kreww', 'Kreww'],
                'category' => 'ai',
                'status' => 'development',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['Agentes de IA · Orquestração · Governança', 'AI agents · Orchestration · Oversight', 'Agentes de IA · Orquestación · Gobernanza'],
                'summary' => [
                    'Equipes de agentes de IA para auxiliar, organizar e automatizar operações empresariais com supervisão humana.',
                    'Specialized AI-agent teams designed to assist, organize and automate business workflows under human supervision.',
                    'Equipos de agentes de IA para asistir, organizar y automatizar operaciones empresariales con supervisión humana.'
                ],
                'has_detail' => 1,
                'detail' => [$krewwDetailPt, $krewwDetailEn, $krewwDetailEs],
                'cover' => 'assets/kreww-banner-official.jpg',
                'theme' => 'kreww',
                'system_url' => null,
                'video_url' => null,
                'featured' => 1,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 12
            ],
            // 13. Xian
            [
                'slug' => 'xian',
                'name' => ['Xian', 'Xian', 'Xian'],
                'category' => 'ai',
                'status' => 'development',
                'org' => ['Independente', 'Independent', 'Independiente'],
                'stack' => ['Python · Flutter · IA Local', 'Python · Flutter · Local AI', 'Python · Flutter · IA Local'],
                'summary' => [
                    'Assistente virtual multidevice com execução local, interface Flutter e integração opcional com backend.',
                    'Cross-device virtual assistant with local-first execution, Flutter interfaces and optional backend integration.',
                    'Asistente virtual multidispositivo con ejecución local, interfaz en Flutter e integración opcional con backend.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 13
            ],
            // 14. ClawBox / OpenClaw Studio
            [
                'slug' => 'clawbox',
                'name' => ['ClawBox / OpenClaw Studio', 'ClawBox / OpenClaw Studio', 'ClawBox / OpenClaw Studio'],
                'category' => 'tool',
                'status' => 'development',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['Agentes de IA · Ferramentas de dev', 'AI agents · Developer tooling', 'Agentes de IA · Herramientas dev'],
                'summary' => [
                    'Ferramenta visual para configurar e gerenciar agentes OpenClaw, com foco em acessibilidade e usabilidade.',
                    'Visual tool for configuring and managing OpenClaw agents, designed for approachability and usability.',
                    'Herramienta visual para configurar y gestionar agentes OpenClaw, enfocada en accesibilidad y usabilidad.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 14
            ],
            // 15. Kicker (Descrição definitiva corrigida!)
            [
                'slug' => 'kicker',
                'name' => ['Kicker', 'Kicker', 'Kicker'],
                'category' => 'tool',
                'status' => 'development',
                'org' => ['Independente', 'Independent', 'Independiente'],
                'stack' => ['Automação · Produtividade · DevTools', 'Automation · Productivity · DevTools', 'Automatización · Productividad · DevTools'],
                'summary' => [
                    'Utilitário de engenharia em desenvolvimento voltado a acelerar o bootstrap de projetos e padronizar rotinas técnicas recorrentes.',
                    'Engineering utility in development focused on accelerating project bootstrapping and standardizing recurring technical workflows.',
                    'Utilidad de ingeniería en desarrollo enfocada en acelerar el arranque de proyectos y estandarizar rutinas técnicas recurrentes.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 15
            ],
            // 16. Survey Android
            [
                'slug' => 'survey-android',
                'name' => ['Survey Android', 'Survey Android', 'Survey Android'],
                'category' => 'data',
                'status' => 'evolving',
                'org' => ['Independente', 'Independent', 'Independiente'],
                'stack' => ['Android · Java · Pesquisa de campo', 'Android · Java · Field research', 'Android · Java · Investigación de campo'],
                'summary' => [
                    'Aplicação móvel de coleta de entrevistas com operação offline, captura de mídia, organização de formulários e sincronização de dados.',
                    'Mobile survey collection app supporting offline workflows, media capture, structured forms and reliable data submission.',
                    'Aplicación móvil para recolección de entrevistas con operación offline, captura multimedia, formularios y sincronización de datos.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 16
            ],
            // 17. UniZap (Descrição definitiva corrigida!)
            [
                'slug' => 'unizap',
                'name' => ['UniZap', 'UniZap', 'UniZap'],
                'category' => 'product',
                'status' => 'development',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['WhatsApp · Comunicação · Integrações', 'WhatsApp · Messaging · Integrations', 'WhatsApp · Comunicación · Integraciones'],
                'summary' => [
                    'Solução corporativa em desenvolvimento para centralização, roteamento e automação de comunicação empresarial via WhatsApp.',
                    'Business solution in development for centralizing, routing and automating corporate communication over WhatsApp.',
                    'Solución corporativa en desarrollo para centralizar, enrutar y automatizar la comunicación empresarial por WhatsApp.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 17
            ],
            // 18. MultiZap (Descrição definitiva corrigida!)
            [
                'slug' => 'multizap',
                'name' => ['MultiZap', 'MultiZap', 'MultiZap'],
                'category' => 'product',
                'status' => 'development',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['WhatsApp · Multiatendimento · Filas', 'WhatsApp · Multi-agent support · Queues', 'WhatsApp · Multiatención · Colas'],
                'summary' => [
                    'Plataforma multiatendimento em desenvolvimento para operação simultânea de equipes, múltiplos canais e gestão de filas no WhatsApp.',
                    'Multi-agent customer support platform in development for team collaboration, multiple channels and queue management on WhatsApp.',
                    'Plataforma multiagente en desarrollo para operación simultánea de equipos, múltiples canales y gestión de colas en WhatsApp.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => null,
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 18
            ],
            // 19. Kodey Sistemas — Website
            [
                'slug' => 'site-kodey',
                'name' => ['Kodey Sistemas — Website', 'Kodey Sistemas — Website', 'Kodey Sistemas — Sitio Web'],
                'category' => 'tool',
                'status' => 'published',
                'org' => ['Kodey', 'Kodey', 'Kodey'],
                'stack' => ['Website · Institucional', 'Website · Corporate', 'Sitio Web · Corporativo'],
                'summary' => [
                    'Site institucional da Kodey, com apresentação de serviços, produtos e soluções de tecnologia.',
                    'Kodey company website presenting software services, products and technology solutions.',
                    'Sitio institucional de Kodey con presentación de servicios, productos y soluciones tecnológicas.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://kodey.com.br/',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 19
            ],
            // 20. Tecmat — Website
            [
                'slug' => 'site-tecmat',
                'name' => ['Tecmat — Website', 'Tecmat — Website', 'Tecmat — Sitio Web'],
                'category' => 'tool',
                'status' => 'published',
                'org' => ['Portfólio Web', 'Web portfolio', 'Portafolio Web'],
                'stack' => ['Website · Engenharia', 'Website · Engineering', 'Sitio Web · Ingeniería'],
                'summary' => [
                    'Site institucional de engenharia e consultoria com portfólio de ensaios e controle tecnológico.',
                    'Engineering and consulting website featuring materials testing and construction quality control.',
                    'Sitio institucional de ingeniería y consultoría con catálogo de ensayos y control tecnológico.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://www.tecmatltda.com.br/',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 20
            ],
            // 21. Protege Radioproteção — Website
            [
                'slug' => 'site-protege',
                'name' => ['Protege Radioproteção — Website', 'Protege Radioproteção — Website', 'Protege Radioprotección — Sitio Web'],
                'category' => 'tool',
                'status' => 'published',
                'org' => ['Portfólio Web', 'Web portfolio', 'Portafolio Web'],
                'stack' => ['Website · Serviços', 'Website · Services', 'Sitio Web · Servicios'],
                'summary' => [
                    'Site institucional de serviços de radioproteção e meio ambiente, com apresentação técnica e canais de atendimento.',
                    'Corporate website for radiation protection and environmental services, presenting capabilities and contact channels.',
                    'Sitio corporativo de servicios de radioprotección y medio ambiente, con información técnica y canales de contacto.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://protegeradioprotecao.com.br/',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 21
            ],
            // 22..26 Other Tools (Kodey / Kodes)
            [
                'slug' => 'kodey-budget',
                'name' => ['Calculadora de Orçamentos', 'Budget Calculator', 'Calculadora de Presupuestos'],
                'category' => 'othertool',
                'status' => 'public',
                'org' => ['Kodey · Kodes', 'Kodey · Kodes', 'Kodey · Kodes'],
                'stack' => ['Web · Produtividade', 'Web · Productivity', 'Web · Productividad'],
                'summary' => [
                    'Ferramenta de produtividade para calcular e organizar valores de orçamentos.',
                    'Productivity tool for calculating and organizing project quotation values.',
                    'Herramienta de productividad para calcular y organizar valores de presupuestos.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://kodey.com.br/kodes/produtividade/calculadora_de_orcamentos/index.html',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 22
            ],
            [
                'slug' => 'kodey-json',
                'name' => ['Smart JSON Formatter', 'Smart JSON Formatter', 'Smart JSON Formatter'],
                'category' => 'othertool',
                'status' => 'public',
                'org' => ['Kodey · Kodes', 'Kodey · Kodes', 'Kodey · Kodes'],
                'stack' => ['Web · DevTools · JSON', 'Web · DevTools · JSON', 'Web · DevTools · JSON'],
                'summary' => [
                    'Utilitário para formatação, validação e leitura de dados JSON durante o desenvolvimento.',
                    'Developer utility for formatting, validating and inspecting JSON payloads.',
                    'Utilidad para formatear, validar e inspeccionar datos JSON durante el desarrollo.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://kodey.com.br/kodes/devtools/smart-json-formatter/index.php',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 23
            ],
            [
                'slug' => 'kodey-palette',
                'name' => ['Paleta de Cores', 'Color Palette Studio', 'Estudio de Paleta de Colores'],
                'category' => 'othertool',
                'status' => 'public',
                'org' => ['Kodey · Kodes', 'Kodey · Kodes', 'Kodey · Kodes'],
                'stack' => ['Web · Design', 'Web · Design', 'Web · Diseño'],
                'summary' => [
                    'Ferramenta online de apoio à escolha, contraste e organização de paletas de cores.',
                    'Online tool to support color palette selection, contrast checking and organization.',
                    'Herramienta online para elegir, validar y organizar paletas de colores.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://kodey.com.br/kodes/design/paleta/index.html',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 24
            ],
            [
                'slug' => 'kodey-solitaire',
                'name' => ['Paciência', 'Solitaire', 'Solitario'],
                'category' => 'othertool',
                'status' => 'public',
                'org' => ['Kodey · Kodes', 'Kodey · Kodes', 'Kodey · Kodes'],
                'stack' => ['Web · Game', 'Web · Game', 'Web · Juego'],
                'summary' => [
                    'Versão web do clássico jogo de cartas Paciência, publicada no catálogo Kodes.',
                    'Web-based classic Solitaire card game published in the Kodes catalogue.',
                    'Versión web del clásico juego de cartas Solitario, publicada en el catálogo Kodes.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://kodey.com.br/kodes/games/paciencia/index.html',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 25
            ],
            [
                'slug' => 'kodey-charts',
                'name' => ['Kodey Charts', 'Kodey Charts', 'Kodey Charts'],
                'category' => 'othertool',
                'status' => 'public',
                'org' => ['Kodey · Open Source', 'Kodey · Open Source', 'Kodey · Open Source'],
                'stack' => ['JavaScript · Chart.js · jQuery · JSON', 'JavaScript · Chart.js · jQuery · JSON', 'JavaScript · Chart.js · jQuery · JSON'],
                'summary' => [
                    'Biblioteca JavaScript open source para gráficos configuráveis por JSON, baseada em Chart.js e jQuery, com opção de exportar imagem.',
                    'Open-source JavaScript charting library driven by simple JSON configuration, built on Chart.js and jQuery, with image export.',
                    'Biblioteca JavaScript open source para gráficos configurables por JSON, basada en Chart.js y jQuery, con exportación de imagen.'
                ],
                'has_detail' => 0,
                'detail' => [null, null, null],
                'cover' => null,
                'theme' => 'default',
                'system_url' => 'https://github.com/alex-o-reis/kodey-charts',
                'video_url' => null,
                'featured' => 0,
                'case_study' => 0,
                'case_order' => 0,
                'case_label' => [null, null, null],
                'case_icon' => null,
                'order' => 26
            ]
        ];

        Model::query("DELETE FROM projects");
        foreach ($projects as $p) {
            Model::query(
                "INSERT INTO projects (
                    slug, name_pt, name_en, name_es,
                    category, status,
                    org_pt, org_en, org_es,
                    stack_pt, stack_en, stack_es,
                    summary_pt, summary_en, summary_es,
                    has_detail_page, detail_json_pt, detail_json_en, detail_json_es,
                    cover_image, theme_key, system_url, video_url,
                    is_featured, is_case_study, case_order,
                    case_label_pt, case_label_en, case_label_es, case_icon,
                    display_order, is_published
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)",
                [
                    $p['slug'], $p['name'][0], $p['name'][1], $p['name'][2],
                    $p['category'], $p['status'],
                    $p['org'][0], $p['org'][1], $p['org'][2],
                    $p['stack'][0], $p['stack'][1], $p['stack'][2],
                    $p['summary'][0], $p['summary'][1], $p['summary'][2],
                    $p['has_detail'],
                    $p['detail'][0] ? $this->j($p['detail'][0]) : null,
                    $p['detail'][1] ? $this->j($p['detail'][1]) : null,
                    $p['detail'][2] ? $this->j($p['detail'][2]) : null,
                    $p['cover'], $p['theme'], $p['system_url'], $p['video_url'],
                    $p['featured'], $p['case_study'], $p['case_order'],
                    $p['case_label'][0], $p['case_label'][1], $p['case_label'][2], $p['case_icon'],
                    $p['order']
                ]
            );
        }
        echo "  -> " . count($projects) . " projetos populados com sucesso.\n";
    }
}
