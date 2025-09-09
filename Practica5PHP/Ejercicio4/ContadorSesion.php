<?php

declare(strict_types=1);

/**
 * Clase ContadorSesion - Contador de Páginas Visitadas por Sesión
 * 
 * Esta clase maneja el conteo de páginas únicas visitadas durante una sesión
 * y mantiene un historial detallado de la navegación.
 * 
 * @author Ejercicio PHP
 * @version 1.0
 */

class ContadorSesion
{
  private const CLAVE_PAGINAS_UNICAS = 'paginas_unicas_visitadas';
  private const CLAVE_HISTORIAL = 'historial_navegacion';
  private const CLAVE_INICIO_SESION = 'inicio_sesion';

  public function __construct()
  {
    $this->iniciarSesion();
  }

  private function iniciarSesion(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Inicializar variables de sesión si no existen
    if (!isset($_SESSION[self::CLAVE_PAGINAS_UNICAS])) {
      $_SESSION[self::CLAVE_PAGINAS_UNICAS] = [];
      $_SESSION[self::CLAVE_HISTORIAL] = [];
      $_SESSION[self::CLAVE_INICIO_SESION] = time();
    }
  }

  public function contarVisita(string $nombrePagina, string $urlPagina = ''): void
  {
    // Registrar en historial completo (todas las visitas)
    $visitaInfo = [
      'pagina' => $nombrePagina,
      'url' => $urlPagina ?: $_SERVER['REQUEST_URI'] ?? '',
      'timestamp' => time(),
      'hora' => date('H:i:s'),
      'fecha' => date('d/m/Y')
    ];

    $_SESSION[self::CLAVE_HISTORIAL][] = $visitaInfo;

    // Agregar a páginas únicas solo si no se ha visitado antes
    $paginasUnicas = $_SESSION[self::CLAVE_PAGINAS_UNICAS];
    if (!in_array($nombrePagina, $paginasUnicas, true)) {
      $_SESSION[self::CLAVE_PAGINAS_UNICAS][] = $nombrePagina;
    }
  }

  public function obtenerContador(): int
  {
    return count($_SESSION[self::CLAVE_PAGINAS_UNICAS] ?? []);
  }

  public function obtenerPaginasUnicas(): array
  {
    return $_SESSION[self::CLAVE_PAGINAS_UNICAS] ?? [];
  }

  public function obtenerHistorial(): array
  {
    return $_SESSION[self::CLAVE_HISTORIAL] ?? [];
  }

  public function obtenerTiempoSesion(): int
  {
    $inicioSesion = $_SESSION[self::CLAVE_INICIO_SESION] ?? time();
    return time() - $inicioSesion;
  }

  public function obtenerTiempoSesionFormateado(): string
  {
    $segundos = $this->obtenerTiempoSesion();
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos % 3600) / 60);
    $segs = $segundos % 60;

    if ($horas > 0) {
      return sprintf('%02d:%02d:%02d', $horas, $minutos, $segs);
    }
    return sprintf('%02d:%02d', $minutos, $segs);
  }

  public function obtenerPaginaMasVisitada(): ?array
  {
    $historial = $this->obtenerHistorial();
    if (empty($historial)) {
      return null;
    }

    $conteos = [];
    foreach ($historial as $visita) {
      $pagina = $visita['pagina'];
      if (!isset($conteos[$pagina])) {
        $conteos[$pagina] = ['nombre' => $pagina, 'visitas' => 0, 'ultima_visita' => ''];
      }
      $conteos[$pagina]['visitas']++;
      $conteos[$pagina]['ultima_visita'] = $visita['hora'];
    }

    // Obtener la página con más visitas
    $masVisitada = null;
    $maxVisitas = 0;
    foreach ($conteos as $pagina) {
      if ($pagina['visitas'] > $maxVisitas) {
        $maxVisitas = $pagina['visitas'];
        $masVisitada = $pagina;
      }
    }

    return $masVisitada;
  }

  public function obtenerEstadisticasPaginas(): array
  {
    $historial = $this->obtenerHistorial();
    if (empty($historial)) {
      return [];
    }

    $estadisticas = [];
    foreach ($historial as $visita) {
      $pagina = $visita['pagina'];
      if (!isset($estadisticas[$pagina])) {
        $estadisticas[$pagina] = [
          'nombre' => $pagina,
          'visitas' => 0,
          'primera_visita' => $visita['hora'] . ' - ' . $visita['fecha'],
          'ultima_visita' => $visita['hora'] . ' - ' . $visita['fecha']
        ];
      }
      $estadisticas[$pagina]['visitas']++;
      $estadisticas[$pagina]['ultima_visita'] = $visita['hora'] . ' - ' . $visita['fecha'];
    }

    // Ordenar por número de visitas (descendente)
    uasort($estadisticas, function ($a, $b) {
      return $b['visitas'] <=> $a['visitas'];
    });

    return array_values($estadisticas);
  }

  public function reiniciarSesion(): void
  {
    $_SESSION[self::CLAVE_PAGINAS_UNICAS] = [];
    $_SESSION[self::CLAVE_HISTORIAL] = [];
    $_SESSION[self::CLAVE_INICIO_SESION] = time();
  }

  public function destruirSesion(): void
  {
    session_destroy();
    session_start();
    session_regenerate_id(true);
    $this->iniciarSesion();
  }

  public function obtenerResumenSesion(): array
  {
    return [
      'paginas_unicas' => $this->obtenerContador(),
      'total_visitas' => count($this->obtenerHistorial()),
      'tiempo_sesion' => $this->obtenerTiempoSesionFormateado(),
      'pagina_mas_visitada' => $this->obtenerPaginaMasVisitada(),
      'inicio_sesion' => date('d/m/Y H:i:s', $_SESSION[self::CLAVE_INICIO_SESION])
    ];
  }
}
