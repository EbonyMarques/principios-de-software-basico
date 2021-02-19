
import yappi
import pandas as pd
from pandas_profiling import ProfileReport as pr
from threading import Thread

class ThreadWithReturnValue(Thread):
    def __init__(self, group=None, target=None, name=None,
                 args=(), kwargs={}, Verbose=None):
        Thread.__init__(self, group, target, name, args, kwargs)
        self._return = None
        
    def run(self):
        # print(type(self._target))
        if self._target is not None:
            self._return = self._target(*self._args,
                                                **self._kwargs)
    def join(self, *args):
        Thread.join(self, *args)
        return self._return


def reader(path, separator = ',', encoding = 'ISO-8859-1', dtype = 'unicode'):
    return pd.read_csv(path, sep = separator, encoding = encoding, dtype = dtype)

def joiner(df1, df2, df3, df4, df5):
    df = df1.join(df2.set_index('CODIGO_IES'), on='CODIGO_IES')
    df = df.join(df3.set_index('CODIGO_IES'), on='CODIGO_IES')
    df = df.join(df4.set_index(['CODIGO_IES','CODIGO_CURSO']), on=['CODIGO_IES','CODIGO_CURSO'])
    df = df.join(df5.set_index(['CODIGO_IES','CODIGO_CURSO']), on=['CODIGO_IES','CODIGO_CURSO'])

    return df

def analyzer(df):
    profile = pr(df, title = 'df', minimal = True, html = {'style':{'full_width':True}})
    profile.to_file('df1.html')

yappi.set_clock_type("cpu")
yappi.start()

paths = ['enade_final2.csv', 'ies_final2.csv', 'igc_novo_metodo.csv', 'cpc_novo_metodo.csv', 'conceito_enade_novo_metodo.csv']
dfs = []

for i in paths:
    thread = ThreadWithReturnValue(target=reader, args=(i,))
    thread.start()
    data = thread.join()
    dfs.append(data)

df = joiner(dfs[0], dfs[1], dfs[2], dfs[3], dfs[4])
analyzer(df)

yappi.stop()
# yappi.get_func_stats().print_all()
yappi.get_thread_stats().print_all()