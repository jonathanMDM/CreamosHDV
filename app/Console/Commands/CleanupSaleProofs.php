<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venta;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Carbon\Carbon;

class CleanupSaleProofs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-sale-proofs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra los comprobantes de venta que tengan más de 7 días para ahorrar espacio en Cloudinary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpieza de comprobantes antiguos...');

        // Buscar ventas con imagen que tengan más de 7 días
        $limite = Carbon::now()->subDays(7);
        $ventas = Venta::whereNotNull('image_url')
                      ->where('created_at', '<', $limite)
                      ->get();

        $count = 0;
        foreach ($ventas as $venta) {
            try {
                // Extraer el public_id de la URL de Cloudinary
                // Las URLs suelen ser https://res.cloudinary.com/cloud_name/image/upload/v12345/folder/public_id.jpg
                $path = parse_url($venta->image_url, PHP_URL_PATH);
                $parts = explode('/', $path);
                $filename = end($parts); // public_id.jpg
                $publicIdWithFolder = 'ventas/' . pathinfo($filename, PATHINFO_FILENAME);

                // Borrar de Cloudinary
                Cloudinary::destroy($publicIdWithFolder);

                // Limpiar la URL en la base de datos
                $venta->update(['image_url' => null]);
                
                $count++;
            } catch (\Exception $e) {
                $this->error("Error al borrar el comprobante de la venta #{$venta->id}: " . $e->getMessage());
            }
        }

        $this->info("¡Limpieza terminada! Se eliminaron {$count} comprobantes antiguos.");
    }
}
