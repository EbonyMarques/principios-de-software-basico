/* 
 * Implementacao do classico exemplo de desenvolvimento de driver para Linux 'kbleds' para o kernel 4.4 por Ebony Marques 
 * Rodrigues. Código testado no Ubuntu 14.04.6 LTS. 
 */

#include <linux/module.h> /* Necessário para todos os módulos */
#include <linux/configfs.h>
#include <linux/init.h> /* Necessário para as macros */
#include <linux/tty.h> /* Necessário para 'fg_console' e 'MAX_NR_CONSOLES' */
#include <linux/kd.h> /* Necessário para 'KDSETLED' */
#include <linux/vt.h>
#include <linux/console_struct.h> /* Necessário para 'vc_cons' */
#include <linux/vt_kern.h>

MODULE_DESCRIPTION("Simples implementacao de um driver para Linux 4.4 que pisca os leds do teclado.");
MODULE_AUTHOR("Ebony Marques Rodrigues");
MODULE_LICENSE("GPL");

struct timer_list my_timer;
struct tty_driver *my_driver;
char kbledstatus = 0;

#define BLINK_DELAY   HZ/5
#define ALL_LEDS_ON   0x07
#define RESTORE_LEDS  0xFF

/* 
 * A funcao 'timer' pisca os leds do teclado periodicamente ao chamar o comando KDSETLET de ioctl() no driver do teclado. 
 */

static void timer(unsigned long ptr)
{
        int *pstatus = (int *)ptr;

        if (*pstatus == ALL_LEDS_ON)
                *pstatus = RESTORE_LEDS;
        else
                *pstatus = ALL_LEDS_ON;

        /* 
         * Eh possivel ver o led piscando o tempo todo ao usar o console virtual 'fg_console' 
         */

        (my_driver->ops->ioctl) (vc_cons[fg_console].d->port.tty, KDSETLED, *pstatus);

        /* 
         * Reativando o timer...
         */

        my_timer.expires = jiffies + BLINK_DELAY;

        add_timer(&my_timer);
}

static int __init kbleds_init(void)
{
        int i;

        printk(KERN_INFO "KBLEDS: Instalando driver...\n");
        printk(KERN_INFO "KBLEDS: 'fgconsole': %x.\n", fg_console);

        /* 
         * Trecho de código para escaneamento de consoles... 
         */

        for (i = 0; i < MAX_NR_CONSOLES; i++) {
                if (!vc_cons[i].d)
                        break;
                printk(KERN_INFO "poet_atkm: console[%i/%i] #%i, tty %lx.\n", i, MAX_NR_CONSOLES, vc_cons[i].d->vc_num,
                       (unsigned long)vc_cons[i].d->port.tty);
        }

        printk(KERN_INFO "KBLEDS: O escaneamento de consoles terminou.\n");
        my_driver = vc_cons[fg_console].d->port.tty->driver;
        printk(KERN_INFO "KBLEDS: Magica do driver tty: %x.\n", my_driver->magic);
        
        /* 
         * Definindo o timer para piscar os leds pela primeira vez 
         */

        init_timer(&my_timer);
        my_timer.function = timer;
        my_timer.data = (unsigned long)&kbledstatus;
        my_timer.expires = jiffies + BLINK_DELAY;
        add_timer(&my_timer);
        
        return 0;
}

static void __exit kbleds_exit(void)
{
        printk(KERN_INFO "KBLEDS: Desinstalando driver...\n");
        del_timer(&my_timer);
        (my_driver->ops->ioctl) (vc_cons[fg_console].d->port.tty, KDSETLED, RESTORE_LEDS);
}

module_init(kbleds_init);
module_exit(kbleds_exit);

