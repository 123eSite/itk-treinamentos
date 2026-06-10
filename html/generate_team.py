people = [
    ('Amine Tarek', 'Amine-Tarek-scaled.jpg', 'Terapeuta'),
    ('Bruno Malatrasi', 'Bruno-Cesar-Malatrasi-Silva_Easy-Resize.com_-e1756331126781-773x1024.jpg', 'Terapeuta'),
    ('Carla Nacif Kadomoto', 'Carla-Nacif-Kadomoto_Easy-Resize.com_-e1756331143495-773x1024.jpg', 'Terapeuta'),
    ('Carlos Roberto S. M. Ciarlo', 'Carlos-Roberto-S.-M.-Ciarlo_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('Elaine Lopes', 'Elaine-Lopes_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('Evelin Elias', 'Evelin-Elias_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('Faustto Rosa', 'Faustto-Oswaldo-de-Rosa-scaled.jpg', 'Terapeuta'),
    ('Felipe Zillo', 'Felipe-Zillo-scaled.jpg', 'Terapeuta'),
    ('Flávia Tonissi Arnosti', 'itk-treinamentos-equipe-flavia-tonissi.jpg', 'Terapeuta'),
    ('Gerson Ramos de Almeida', 'Gerson-Ramos-de-Almeida_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('Heloisa Helena Lacerda Calil', 'itk-treinamentos-equipe-heloisa-helena.jpg', 'Terapeuta'),
    ('Ingrid Prates', 'Ingrid-Prates-scaled.jpg', 'Terapeuta'),
    ('Ivana Rodrigues', 'Ivana-Rodrigues_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('João de Souza Filho', 'Joao-de-Souza-Filho_Easy-Resize.com_.jpg', 'Terapeuta'),
    ('Julia Kadomoto', 'Julia-Nacif-Kadomoto-scaled.jpg', 'Terapeuta'),
    ('Maria Gomes de Carvalho Filha', 'itk-treinamentos-equipe-maria-gomes.jpg', 'Terapeuta'),
    ('Maria Tereza Vitor', 'itk-treinamentos-maria-tereza-vitor.jpg', 'Terapeuta'),
    ('Mariene Rodrigues', 'Mariene-Rodrigues-scaled.jpg', 'Terapeuta'),
    ('Nielson Brambati', 'Nielson-Roberto-Santana-scaled.jpg', 'Terapeuta'),
    ('Rafael Kadomoto', 'Rafael-Kadomoto_Easy-Resize.com_-e1756331105600-773x1024.jpg', 'Terapeuta'),
    ('Robson Hamuche', 'itk-treinamentos-equipe-robson-hamuche.jpg', 'Terapeuta'),
    ('Tadashi Kadomoto', 'Tadashi-Kadomoto-scaled-e1756330599930.jpg', 'Cargo/Profissão'),
    ('Valdir Pinto de Souza Júnior', 'Valdir-Pinto-de-Souza-Junior-scaled.jpg', 'Terapeuta')
]

out = '                <div class=\"row\">\\n'
for name, img, role in people:
    out += f'''                    <div class=\"col-lg-2 col-md-6 col-sm-6\">
                        <div class=\"team-member2\">
                            <div class=\"team-card\">
                                <div class=\"team-img\">
                                    <a href=\"#\"><img src=\"assets/images/{img}\" alt=\"Equipe ITK - {name}\"></a>
                                    <div class=\"team-shap\"></div>
                                </div>
                                <div class=\"team-content\">
                                    <div class=\"share-box\">
                                        <span class=\"share-icon fa fa-share-alt\"></span>
                                        <ul class=\"social-links\">
                                            <li><a href=\"http://www.linkedin.com/\" target=\"_blank\" title=\"\"><i class=\"fab fa-linkedin-in\"></i></a></li>
                                            <li><a href=\"https://www.instagram.com/\" target=\"_blank\" title=\"\"><i class=\"fab fa-instagram\"></i></a></li>
                                        </ul>
                                    </div>
                                    <h4 class=\"name\"><a href=\"#\" title=\"\">{name}</a></h4>
                                    <span class=\"designation\">{role}</span>
                                </div>
                            </div>
                        </div>
                    </div>\\n'''
out += '                </div>'

with open('temp_html_team.txt', 'w', encoding='utf-8') as f:
    f.write(out)
