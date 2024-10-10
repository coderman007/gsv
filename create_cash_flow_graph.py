import matplotlib.pyplot as plt
import json
import sys

# Cargar los datos desde el argumento JSON pasado por PHP
accumulated_cash_flow = json.loads(sys.argv[1])

# Preparar los datos para la gráfica
years = list(accumulated_cash_flow.keys())
values = list(accumulated_cash_flow.values())

# Crear la gráfica
plt.figure(figsize=(10, 6))
plt.plot(years, values, marker='o', color='b')
plt.title('Flujo de Caja Acumulado')
plt.xlabel('Año')
plt.ylabel('Flujo de Caja ($)')
plt.grid(True)

# Guardar la gráfica como una imagen PNG
plt.savefig('flujo_caja_acumulado.png')
