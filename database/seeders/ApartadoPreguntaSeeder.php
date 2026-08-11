<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Rubrica;
use App\Models\Apartado;
use App\Models\Pregunta;

class ApartadoPreguntaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos los mapas de [Nombre => ID] de la base de datos automáticamente
        $categorias = Categoria::pluck('ID_Categoria', 'Nombre')->toArray();
        $rubricas   = Rubrica::pluck('ID_Rubrica', 'Nombre')->toArray();

        // =========================================================================
        // ESTRUCTURA GENERAL DE DATOS
        // Fuente: "Anexo 1. ExpoTEC 2026 vers 19 05 2026 (2).xlsx"
        // Escala española: 3 (Logrado) / 2 (Parcialmente) / 1 (No logrado) / 0 (Ausente)
        // Escala inglés:   5 (Exceptional) / 4 / 3 / 2 / 1 (Unsatisfactory)
        // =========================================================================
        $matrizDatos = [

            // ---------------------------------------------------------------------
            // 1. CATEGORÍA: STEAM  |  RÚBRICA: EXPOSICIÓN  (Hoja ExpoTEC-7, máx 111)
            // ---------------------------------------------------------------------
            'Steam' => [

                'Exposición' => [
                    [
                        'Titulo' => 'I. Identificación y formulación del problema.',
                        'Orden'  => 1,
                        'preguntas' => [
                            ['Pregunta' => 'a. Define el problema de forma precisa.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Plantea alternativas de solución que contemplen conceptos teóricos prácticos atinentes al problema.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Propone objetivos vinculados con la búsqueda de soluciones al problema planteado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Evidencia el impacto del proyecto a nivel social, científico o tecnológico, tanto a corto como largo plazo.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Demuestra capacidad para expresar ideas con seguridad y defender el proyecto planteado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'a. Demuestra en su elaboración una línea de investigación y desarrollo coherente y clara.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Argumenta, desde la implementación del proyecto, el análisis e interpretación de los datos recopilados.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Evidencia la gestión de recursos y búsqueda de apoyo para la elaboración del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Demuestra originalidad y autoría propia del proyecto expuesto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Aplica la normativa vigente en el contexto del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Se evidencia la factibilidad e implementación comercial o industrial del proyecto, a futuro.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'III. Prototipo',
                        'Orden'  => 2,
                        'preguntas' => [
                            ['Pregunta' => 'a. Presenta una línea de trabajo de investigación y desarrollo coherente y clara.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Da respuesta a la necesidad u objetivos planteados.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Evidencia el uso óptimo de los recursos disponibles para su construcción.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Demuestra precisión técnica en la elaboración y funcionamiento del prototipo, al aplicar de forma correcta los conocimientos científicos y tecnológicos en la solución presentada.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Respeta las normativas de seguridad y otras vigentes en su construcción y desempeño.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Muestra actualidad tecnológica en el campo de trabajo seleccionado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Evidencia el funcionamiento correcto según la solución planteada en el proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Demuestra creatividad e innovación en el desarrollo de ideas nuevas o mejoradas al crear el prototipo.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'IV. Exposición del proyecto.',
                        'Orden'  => 3,
                        'preguntas' => [
                            ['Pregunta' => 'a. Evidencia apropiación y dominio del tema del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Demuestra claridad y coherencia en la exposición del proyecto ante el panel de jueces.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Utiliza lenguaje técnico acorde con el nivel académico y el campo de desarrollo del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Argumenta de forma sólida y fundamentada su propuesta de proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Emplea recursos afines con el tema del proyecto (diseños, diagramas, gráficos, esquemas, modelos, programas de computación, equipos, entre otros).', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Describe la metodología utilizada para la implementación, evaluación y perfeccionamiento de la solución propuesta.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Presenta resultados consistentes con los objetivos y solución al problema planteado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'h. Brinda conclusiones precisas y objetivas basadas en los resultados obtenidos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'i. Denota colaboración y comunicación efectiva del estudiante o integrantes del equipo, según corresponda.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'j. Demuestra capacidad de recibir, analizar y aplicar sugerencias para mejorar el proyecto.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'V. Documentación del proyecto.',
                        'Orden'  => 4,
                        'preguntas' => [
                            ['Pregunta' => 'Informe escrito: a. Se evidencia congruencia entre lo expuesto por la persona estudiante o equipo y el informe escrito.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'Informe escrito: b. Evidencia el uso de lenguaje técnico afín al tema del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'Informe escrito: c. Estipula los procedimientos técnicos utilizados.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'La bitácora detalla en forma cronológica los procesos de: a. Investigación.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'La bitácora detalla en forma cronológica los procesos de: b. Implementación.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'La bitácora detalla en forma cronológica los procesos de: c. Experimentación.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'Cartel de presentación (etapa institucional) o recursos audiovisuales (etapa nacional): a. Contiene información relevante para la exposición del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'Cartel de presentación (etapa institucional) o recursos audiovisuales (etapa nacional): b. Utiliza el cartel como recurso y apoyo para el desarrollo de la exposición.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                ],

                // ---------------------------------------------------------------------
                // 2. CATEGORÍA: STEAM  |  RÚBRICA: TRABAJO ESCRITO  (Hoja ExpoTEC-10, máx 105)
                // ---------------------------------------------------------------------
                'Trabajo Escrito' => [
                    [
                        'Titulo' => 'I. Introducción',
                        'Orden'  => 1,
                        'preguntas' => [
                            ['Pregunta' => 'a. Delimita los antecedentes del problema o necesidad por solventar.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Evidencia claridad en la definición del problema.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Fundamenta la relevancia o utilidad potencial del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Define los criterios técnicos utilizados para la solución del problema.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Evidencia la viabilidad del proyecto.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'II. Marco teórico',
                        'Orden'  => 2,
                        'preguntas' => [
                            ['Pregunta' => 'a. Emplea variedad de fuentes de información confiables para sustentar el proyecto (tesis, libros, artículos, entrevistas, repositorios y páginas Web, entre otros).', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Incluye citas bibliográficas relevantes, de forma crítica dentro del texto, que documentan la investigación y desarrollo del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Emplea fuentes bibliográficas actualizadas, según el tema abordado en el proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Define términos o conceptos relevantes para la investigación y desarrollo del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Sintetiza la información existente del tema en estudio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Evidencia la organización lógica de la información recopilada.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'III. Objetivos',
                        'Orden'  => 3,
                        'preguntas' => [
                            ['Pregunta' => 'a. Presenta el objetivo general y al menos dos objetivos específicos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Se plantean de forma clara, precisa y según estructura requerida: verbo en infinitivo, contenido y condición técnica.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Evidencia relación con la propuesta de solución planteada.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'IV. Metodología',
                        'Orden'  => 4,
                        'preguntas' => [
                            ['Pregunta' => 'a. Presenta las etapas del proyecto en el cronograma.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Cumple con las etapas establecidas en el cronograma.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Describe paso a paso los procedimientos y técnicas utilizadas para la investigación y desarrollo.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Describe los recursos utilizados para la implementación del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Evidencia procesos de mejora continua durante la investigación y desarrollo del proyecto.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Evidencia el desarrollo de ideas novedosas o la aplicación creativa de conocimientos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Fundamenta los cálculos requeridos para las demostraciones.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'h. Incluye diseños y esquemas claros en relación con el desarrollo del prototipo.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'V. Discusión de los resultados y conclusiones',
                        'Orden'  => 5,
                        'preguntas' => [
                            ['Pregunta' => 'a. Muestra concordancia entre los resultados obtenidos y los objetivos planteados.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Presenta los datos mediante tablas, diagramas, figuras, gráficos, entre otros, que sustenten los resultados obtenidos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Evidencia la interpretación de los resultados desde una visión analítica y reflexiva, sin delimitarse a describirlos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Demuestra resultados (producto) aplicables y útiles en la vida real.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Presenta coherencia entre los diseños y esquemas con respecto al prototipo desarrollado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Plantea conclusiones relevantes en relación con los objetivos trazados, análisis de datos y prototipado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Concluye sobre el impacto ambiental, social o económico de la implementación del proyecto.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'VI. Estructura y formato del proyecto',
                        'Orden'  => 6,
                        'preguntas' => [
                            ['Pregunta' => 'a. Presenta una organización clara y lógica, en congruencia con la estructura dada en los lineamientos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Presenta el documento en formato de doble columna (IEEE, artículo de revista).', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Presenta el listado de referencias citadas en el documento, según formato APA vigente.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                    [
                        'Titulo' => 'VII. Bitácora',
                        'Orden'  => 7,
                        'preguntas' => [
                            ['Pregunta' => 'a. Evidencia el proceso de investigación y desarrollo realizado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Cumple con el formato solicitado, según los lineamientos de la ExpoTÉCNICA.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Presenta relación con el informe escrito.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                ],

            ],

            // ---------------------------------------------------------------------
            // 3. CATEGORÍA: EMPRENDIMIENTO  |  RÚBRICA: EXPOSICIÓN  (Hoja ExpoTEC-8, máx 54)
            // ---------------------------------------------------------------------
            'Emprendimiento' => [

                'Exposición' => [
                    [
                        'Titulo' => 'Indicadores de evaluación',
                        'Orden'  => 1,
                        'preguntas' => [
                            ['Pregunta' => 'a. Define de forma precisa la operación básica de la potencial empresa.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Plantea las alternativas de solución que la empresa brindará al problema o necesidad detectada.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Describe los productos o servicios ofrecidos que brindan valor a los clientes,.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Evidencia el impacto la potencial empresa desde diversos ámbitos, tanto a corto, como a largo plazo.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Argumenta las diferencias que ofrece la potencial empresa con la competencia.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Demuestra un buen entendimiento del mercado, la competencia y aspectos financieros.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Argumenta con solidez qué hace único al negocio y porqué constituye una buena oportunidad.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'h. Demuestra gestión de los recursos de forma sostenible y responsable.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'i. Demuestra claridad y coherencia en la exposición del plan de negocios ante el panel de jueces.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'j. Utiliza lenguaje técnico acorde con el nivel académico y el campo del negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'k. Evidencia capacidad de comunicación oral y dominio de la propuesta de valor.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'l. Define los canales mediante los cuales hará llegar a los clientes la propuesta de valor.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'm. Caracteriza el segmento de clientes (necesidades - comportamientos - atributos).', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'n. Expone una propuesta innovadora y creativa con respecto al mercado.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'o. Describe las demandas del segmento de clientes y el seguimiento para asegurar la calidad de los bienes o servicios ofrecidos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'p. Expone las fuentes de ingresos y estructura de costos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'q. Explica los canales utilizados para dar a conocer su modelo de negocios.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'r. Describe las alianzas estratégicas de su propuesta de valor.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                ],

                // ---------------------------------------------------------------------
                // 4. CATEGORÍA: EMPRENDIMIENTO  |  RÚBRICA: TRABAJO ESCRITO  (Hoja ExpoTEC-11, máx 72)
                // ---------------------------------------------------------------------
                'Trabajo Escrito' => [
                    [
                        'Titulo' => 'Indicadores de evaluación',
                        'Orden'  => 1,
                        'preguntas' => [
                            ['Pregunta' => 'a. Describe de forma clara y precisa los antecedentes que fundamentan la propuesta de valor', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'b. Explica con solidez qué hace único al negocio y porqué es atractivo.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'c. Describe las actividades clave que la empresa implementa para ofrecer una propuesta de valor.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'd. Describe de forma detallada el producto o servicio propuesto que brindan valor a los clientes.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'e. Detalla cómo los productos o servicios ofrecidos se diferencian de la competencia.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'f. Emplea lenguaje técnico acorde con el nivel académico y el campo del negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'g. Define los canales mediante los cuales hará llegar a los clientes la propuesta de valor.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'h. Caracteriza ampliamente el segmento de clientes (Necesidades - comportamientos - atributos).', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'i. Presenta los elementos diferenciadores que facilitan la decisión de compra del cliente.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'j. Describe las demandas del segmento de clientes y el seguimiento para asegurar la calidad de los bienes o servicios ofrecidos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'k. Presenta las estrategias para el acercamiento al cliente, ya sea durante el proceso de atención o de servicio,', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'l. Presenta datos sobre clientes, tendencias y oportunidades.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'm. Incluye estrategias de promoción, precios, distribución y posicionamiento.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'n. Presenta la estructura de costos, gastos e ingresos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'o. Incluye los canales para la distribución del producto hasta el cliente y su promoción, incorporando el uso de nuevas tecnologías.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'p. Detalla las alianzas estratégicas y aportes a su propuesta de valor.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'q. Presenta una organización clara y lógica del documento, en congruencia con la estructura dada en los lineamientos.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'r. Presenta el listado de referencias citadas en el documento, según formato APA vigente.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 's. Cumple con el formato establecido.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 't. Justifica de forma sólida la viabilidad y pertinencia del negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'u. Identifica la situación de mercado, sociedad o industria que se aborda en la propuesta de negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'v. Argumenta la necesidad o problema que resuelve la propuesta de negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'w. Determina aspectos sociales, económicos, tecnológicos o ambientales que resuelve la propuesta de negocio.', 'Maxima_Calificacion' => 3],
                            ['Pregunta' => 'x. Plantea los objetivos del negocio enfatizando en su viabilidad, escalabilidad y sostenibilidad.', 'Maxima_Calificacion' => 3],
                        ],
                    ],
                ],

            ],

            // ---------------------------------------------------------------------
            // 5. CATEGORÍA: INGLÉS  |  RÚBRICA: EXPOSICIÓN  (Hoja ExpoTEC-13, máx 40, escala 1-5)
            // ---------------------------------------------------------------------
            'Inglés' => [

                'Exposición' => [
                    [
                        'Titulo' => 'Use of Language',
                        'Orden'  => 1,
                        'preguntas' => [
                            ['Pregunta' => 'Organization of Ideas', 'Maxima_Calificacion' => 5],
                            ['Pregunta' => 'Vocabulary', 'Maxima_Calificacion' => 5],
                            ['Pregunta' => 'Sentence Structure and Grammar', 'Maxima_Calificacion' => 5],
                            ['Pregunta' => 'Pronunciation', 'Maxima_Calificacion' => 5],
                        ],
                    ],
                    [
                        'Titulo' => 'Content',
                        'Orden'  => 2,
                        'preguntas' => [
                            ['Pregunta' => 'Content', 'Maxima_Calificacion' => 5],
                        ],
                    ],
                    [
                        'Titulo' => 'Conclusion',
                        'Orden'  => 3,
                        'preguntas' => [
                            ['Pregunta' => 'Conclusion', 'Maxima_Calificacion' => 5],
                        ],
                    ],
                    [
                        'Titulo' => 'Delivery',
                        'Orden'  => 4,
                        'preguntas' => [
                            ['Pregunta' => 'Verbal', 'Maxima_Calificacion' => 5],
                            ['Pregunta' => 'Nonverbal', 'Maxima_Calificacion' => 5],
                        ],
                    ],
                ],

            ],

        ];

        // =========================================================================
        // PROCESAMIENTO AUTOMÁTICO
        // =========================================================================
        foreach ($matrizDatos as $nombreCategoria => $rubricasData) {
            if (!isset($categorias[$nombreCategoria])) {
                $this->command->warn("La categoría '{$nombreCategoria}' no existe en la BD.");
                continue;
            }

            foreach ($rubricasData as $nombreRubrica => $apartados) {
                if (!isset($rubricas[$nombreRubrica])) {
                    $this->command->warn("La rúbrica '{$nombreRubrica}' no existe en la BD.");
                    continue;
                }

                $idCategoria = $categorias[$nombreCategoria];
                $idRubrica   = $rubricas[$nombreRubrica];

                foreach ($apartados as $dataApartado) {

                    $apartado = Apartado::firstOrCreate(
                        [
                            'Titulo'       => $dataApartado['Titulo'],
                            'ID_Categoria' => $idCategoria,
                            'ID_Rubrica'   => $idRubrica,
                        ],
                        [
                            'Orden'  => $dataApartado['Orden'] ?? 1,
                            'Estado' => $dataApartado['Estado'] ?? 'Activo',
                        ]
                    );

                    foreach ($dataApartado['preguntas'] as $dataPregunta) {
                        Pregunta::firstOrCreate(
                            [
                                'Pregunta'    => $dataPregunta['Pregunta'],
                                'ID_Apartado' => $apartado->ID_Apartado,
                            ],
                            [
                                'Maxima_Calificacion' => $dataPregunta['Maxima_Calificacion'] ?? 5,
                                'Estado'              => $dataPregunta['Estado'] ?? 'Activo',
                            ]
                        );
                    }
                }
            }
        }

        $this->command->info('¡Indicadores del Anexo 1 registrados correctamente!');
    }
}
