<?php

namespace Ivory\GoogleMapBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Ivory google map extension
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class IvoryGoogleMapExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        foreach(array('services.xml') as $file)
            $loader->load($file);

        // Map sections
        $this->loadMap($config, $container);
        
        // Base sections
        $this->loadCoordinate($config, $container);
        $this->loadBound($config, $container);
        $this->loadPoint($config, $container);
        $this->loadSize($config, $container);
        
        // Control sections
        $this->loadMapTypeControl($config, $container);
        $this->loadOverviewMapControl($config, $container);
        $this->loadPanControl($config, $container);
        $this->loadRotateControl($config, $container);
        $this->loadScaleControl($config, $container);
        $this->loadStreetViewControl($config, $container);
        $this->loadZoomControl($config, $container);
        
        // Marker sections
        $this->loadMarker($config, $container);
        $this->loadMarkerImage($config, $container);
        $this->loadMarkerShape($config, $container);
        
        // Overlay sections
        $this->loadInfoWindow($config, $container);
        $this->loadPolyline($config, $container);
        $this->loadPolygon($config, $container);
        $this->loadRectangle($config, $container);
        $this->loadCircle($config, $container);
        $this->loadGroundOverlay($config, $container);
        
        // Event sections
        $this->loadEvent($config, $container);

        if($config['twig']['enabled'])
            $loader->load('twig.xml');
    }
    
    /**
     * Loads map configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadMap(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.map.prefix_javascript_variable', $config['map']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.map.html_container', $config['map']['html_container']);
        $container->setParameter('ivory_google_map.map.auto_zoom', $config['map']['auto_zoom']);
        $container->setParameter('ivory_google_map.map.center.longitude', $config['map']['center']['longitude']);
        $container->setParameter('ivory_google_map.map.center.latitude', $config['map']['center']['latitude']);
        $container->setParameter('ivory_google_map.map.center.no_wrap', $config['map']['center']['no_wrap']);
        $container->setParameter('ivory_google_map.map.type', $config['map']['type']);
        $container->setParameter('ivory_google_map.map.zoom', $config['map']['zoom']);
        $container->setParameter('ivory_google_map.map.width', $config['map']['width']);
        $container->setParameter('ivory_google_map.map.height', $config['map']['height']);
        $container->setParameter('ivory_google_map.map.map_options', $config['map']['map_options']);
        $container->setParameter('ivory_google_map.map.stylesheet_options', $config['map']['stylesheet_options']);
    }
    
    /**
     * Loads coordinate configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadCoordinate(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.coordinate.latitude', $config['coordinate']['latitude']);
        $container->setParameter('ivory_google_map.coordinate.longitude', $config['coordinate']['longitude']);
        $container->setParameter('ivory_google_map.coordinate.no_wrap', $config['coordinate']['no_wrap']);
    }
    
    /**
     * Loads bound configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadBound(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.bound.prefix_javascript_variable', $config['bound']['prefix_javascript_variable']);
    }
    
    /**
     * Loads point configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadPoint(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.point.x', $config['point']['x']);
        $container->setParameter('ivory_google_map.point.y', $config['point']['y']);
    }
    
    /**
     * Loads size configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadSize(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.size.width', $config['size']['width']);
        $container->setParameter('ivory_google_map.size.height', $config['size']['height']);
        $container->setParameter('ivory_google_map.size.width_unit', $config['size']['width_unit']);
        $container->setParameter('ivory_google_map.size.height_unit', $config['size']['height_unit']);
    }
    
    /**
     * Loads map type control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadMapTypeControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.map_type_control.map_type_ids', $config['map_type_control']['map_type_ids']);
        $container->setParameter('ivory_google_map.map_type_control.control_position', $config['map_type_control']['control_position']);
        $container->setParameter('ivory_google_map.map_type_control.map_type_control_style', $config['map_type_control']['map_type_control_style']);
    }
    
    /**
     * Loads overview map control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadOverviewMapControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.overview_map_control.opened', $config['overview_map_control']['opened']);
    }
    
    /**
     * Loads pan control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadPanControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.pan_control.control_position', $config['pan_control']['control_position']);
    }
    
    /**
     * Loads rotate control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadRotateControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.rotate_control.control_position', $config['rotate_control']['control_position']);
    }
    
    /**
     * Loads scale control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadScaleControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.scale_control.control_position', $config['scale_control']['control_position']);
        $container->setParameter('ivory_google_map.scale_control.scale_control_style', $config['scale_control']['scale_control_style']);
    }
    
    /**
     * Loads street view control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadStreetViewControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.street_view_control.control_position', $config['street_view_control']['control_position']);
    }
    
    /**
     * Loads zoom control configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadZoomControl(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.zoom_control.control_position', $config['zoom_control']['control_position']);
        $container->setParameter('ivory_google_map.zoom_control.zoom_control_style', $config['zoom_control']['zoom_control_style']);
    }
    
    /**
     * Loads marker configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadMarker(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.marker.prefix_javascript_variable', $config['marker']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.marker.position.latitude', $config['marker']['position']['latitude']);
        $container->setParameter('ivory_google_map.marker.position.longitude', $config['marker']['position']['longitude']);
        $container->setParameter('ivory_google_map.marker.position.no_wrap', $config['marker']['position']['no_wrap']);
        $container->setParameter('ivory_google_map.marker.options', $config['marker']['options']);
    }
    
    /**
     * Loads marker image configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadMarkerImage(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.marker_image.prefix_javascript_variable', $config['marker_image']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.marker_image.url', $config['marker_image']['url']);
    }
    
    /**
     * Loads marker shape configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadMarkerShape(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.marker_shape.prefix_javascript_variable', $config['marker_shape']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.marker_shape.type', $config['marker_shape']['type']);
    }
    
    /**
     * Loads info window configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadInfoWindow(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.info_window.prefix_javascript_variable', $config['info_window']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.info_window.position.latitude', $config['info_window']['position']['latitude']);
        $container->setParameter('ivory_google_map.info_window.position.longitude', $config['info_window']['position']['longitude']);
        $container->setParameter('ivory_google_map.info_window.position.no_wrap', $config['info_window']['position']['no_wrap']);
        $container->setParameter('ivory_google_map.info_window.content', $config['info_window']['content']);
        $container->setParameter('ivory_google_map.info_window.options', $config['info_window']['options']);
        $container->setParameter('ivory_google_map.info_window.open', $config['info_window']['open']);
    }
    
    /**
     * Loads polyline configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadPolyline(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.polyline.prefix_javascript_variable', $config['polyline']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.polyline.options', $config['polyline']['options']);
    }
    
    /**
     * Loads polygon configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadPolygon(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.polygon.prefix_javascript_variable', $config['polygon']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.polygon.options', $config['polygon']['options']);
    }
    
    /**
     * Loads rectangle configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadRectangle(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.rectangle.prefix_javascript_variable', $config['rectangle']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.rectangle.bound.south_west.latitude', $config['rectangle']['bound']['south_west']['latitude']);
        $container->setParameter('ivory_google_map.rectangle.bound.south_west.longitude', $config['rectangle']['bound']['south_west']['longitude']);
        $container->setParameter('ivory_google_map.rectangle.bound.south_west.no_wrap', $config['rectangle']['bound']['south_west']['no_wrap']);
        $container->setParameter('ivory_google_map.rectangle.bound.north_east.latitude', $config['rectangle']['bound']['north_east']['latitude']);
        $container->setParameter('ivory_google_map.rectangle.bound.north_east.longitude', $config['rectangle']['bound']['north_east']['longitude']);
        $container->setParameter('ivory_google_map.rectangle.bound.north_east.no_wrap', $config['rectangle']['bound']['north_east']['no_wrap']);
        $container->setParameter('ivory_google_map.rectangle.options', $config['rectangle']['options']);
    }
    
    /**
     * Loads circle configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadCircle(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.circle.prefix_javascript_variable', $config['circle']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.circle.center.longitude', $config['circle']['center']['longitude']);
        $container->setParameter('ivory_google_map.circle.center.latitude', $config['circle']['center']['latitude']);
        $container->setParameter('ivory_google_map.circle.center.no_wrap', $config['circle']['center']['no_wrap']);
        $container->setParameter('ivory_google_map.circle.radius', $config['circle']['radius']);
        $container->setParameter('ivory_google_map.circle.options', $config['circle']['options']);
    }
    
    /**
     * Loads ground overlay configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadGroundOverlay(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.ground_overlay.prefix_javascript_variable', $config['ground_overlay']['prefix_javascript_variable']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.south_west.latitude', $config['ground_overlay']['bound']['south_west']['latitude']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.south_west.longitude', $config['ground_overlay']['bound']['south_west']['longitude']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.south_west.no_wrap', $config['ground_overlay']['bound']['south_west']['no_wrap']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.north_east.latitude', $config['ground_overlay']['bound']['north_east']['latitude']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.north_east.longitude', $config['ground_overlay']['bound']['north_east']['longitude']);
        $container->setParameter('ivory_google_map.ground_overlay.bound.north_east.no_wrap', $config['ground_overlay']['bound']['north_east']['no_wrap']);
        $container->setParameter('ivory_google_map.ground_overlay.options', $config['ground_overlay']['options']);
    }
    
    /**
     * Loads event configuration
     *
     * @param array $config
     * @param ContainerBuilder $container 
     */
    protected function loadEvent(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ivory_google_map.event.prefix_javascript_variable', $config['event']['prefix_javascript_variable']);
    }
}
