import matplotlib.pyplot as plt
import csv
import locale

def plot_cashflow_from_csv(file_path, olive_intensity=0.6, yellow_intensity=0.8):
    years = []
    accumulated_cash_flow = []

    # Configurar la localización para formato de moneda (Colombia)
    locale.setlocale(locale.LC_ALL, 'es_CO.UTF-8')

    # Leer el archivo CSV
    with open(file_path, newline='') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            years.append(int(row['Year']))
            accumulated_cash_flow.append(float(row['Accumulated Cash Flow']))

    # Definir colores: verde oliva para valores positivos, amarillo con intensidad ajustable para negativos
    olive_green = (0.5 * olive_intensity, 0.8 * olive_intensity, 0.4 * olive_intensity)  # Verde oliva
    yellow = (1.0 * yellow_intensity, 0.8 * yellow_intensity, 0.2 * yellow_intensity)  # Amarillo ajustable
    colors = [olive_green if value >= 0 else yellow for value in accumulated_cash_flow]

    # Ajustar el tamaño de la figura (aumentar el ancho)
    plt.figure(figsize=(14, 6))  # 12 es el ancho, 6 es la altura

    # Crear gráfico de barras
    plt.bar(years, accumulated_cash_flow, color=colors)

    # Filtrar los años clave y sus valores correspondientes
    specific_years = [1, 5, 10, 15, 20, 25]
    specific_values = [accumulated_cash_flow[years.index(year)] for year in specific_years]

    # Formatear las etiquetas del eje Y con el símbolo de pesos y separador de miles
    plt.yticks(specific_values, [f'$ {locale.format_string("%.0f", value, grouping=True)}' for value in specific_values], fontsize=12)

    # Aumentar el tamaño de las etiquetas del eje X
    plt.xticks(years, fontsize=12)

    # Título y etiquetas en español con fuente aumentada
    plt.title('Flujo de Caja Acumulado Durante 25 Años', fontsize=14)
    plt.xlabel('Años', fontsize=12)
    plt.ylabel('Pesos', fontsize=12)

    # Mostrar la cuadrícula
    plt.grid(True, axis='y', linestyle='--', alpha=0.7)

    # Guardar el gráfico en un archivo de imagen
    plt.savefig('C:/xampp/htdocs/laravel_projects/gsv/public/images/cashflow_chart.png')

    # Cerrar la gráfica para liberar memoria
    plt.close()

# Especificar la ruta al archivo CSV
csv_file_path = 'C:/xampp/htdocs/laravel_projects/gsv/storage/app/cash_flow.csv'
plot_cashflow_from_csv(csv_file_path, olive_intensity=0.6, yellow_intensity=0.8)
