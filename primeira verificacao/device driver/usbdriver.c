/* 
 * Implementacao de um driver de dispositivo USB para o kernel 5.4 por Ebony Marques Rodrigues. 
 * Código testado no Ubuntu 20.04 LTS. 
 */

#include <linux/kernel.h>
#include <linux/module.h>
#include <linux/usb.h>

/*
** A funcao 'usb_probe' é chamada sempre que o dispositivo for conectado
*/

static int usb_probe(struct usb_interface *interface, const struct usb_device_id *id)
{
    dev_info(&interface->dev, "Dispositivo USB conectado.");
    dev_info(&interface->dev, "Vendor ID: 0x0%02x. Product ID: 0x0%02x.\n", id->idVendor, id->idProduct);
    return 0;  //return 0 indicates we are managing this device
}

/*
** A funcao 'usb_disconnect' é chamada sempre que o dispositivo for desconectado
*/

static void usb_disconnect(struct usb_interface *interface)
{
    dev_info(&interface->dev, "Dispositivo USB desconectado.\n");
}

/*
 * 'usb_device_id' prove uma lista de tipos de dispositivos USB suportados pelo driver
 */

const struct usb_device_id usb_table[] = {
    { USB_DEVICE( 0x0BDA, 0x0129 ) }, /* Vendor ID e Product ID */
    { }
};

/* A estrutura deve ser registrada no subsistema Linux */
static struct usb_driver usb_driver = {
    .name       = "Driver do dispositivo USB",
    .probe      = usb_probe,
    .disconnect = usb_disconnect,
    .id_table   = usb_table,
};

static int __init usb_init(void)
{
    /* Registrando o dispositivo USB */
    return usb_register(&usb_driver);
}

static void __exit usb_exit(void)
{
    /* Desregistrando o dispositivo USB */
    usb_deregister(&usb_driver);
}

module_init(usb_init);
module_exit(usb_exit);

MODULE_LICENSE("GPL");
MODULE_AUTHOR("Ebony Marques Rodrigues");
MODULE_DESCRIPTION("Driver de dispositivo USB.");
MODULE_VERSION("1.0");