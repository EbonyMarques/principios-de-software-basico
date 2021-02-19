import yappi
import pandas as pd
from pandas_profiling import ProfileReport as pr

def reader():
    df1 = pd.read_csv('enade_final2.csv', sep = ',', encoding = 'ISO-8859-1', dtype = 'unicode')
    df2 = pd.read_csv('ies_final2.csv', sep = ',', encoding = 'ISO-8859-1', dtype = 'unicode')
    df3 = pd.read_csv('igc_novo_metodo.csv', sep = ',', encoding = 'ISO-8859-1', dtype = 'unicode')
    df4 = pd.read_csv('cpc_novo_metodo.csv', sep = ',', encoding = 'ISO-8859-1', dtype = 'unicode')
    df5 = pd.read_csv('conceito_enade_novo_metodo.csv', sep = ',', encoding = 'ISO-8859-1', dtype = 'unicode')

    return df1, df2, df3, df4, df5

def joiner(df1, df2, df3, df4, df5):
    df = df1.join(df2.set_index('CODIGO_IES'), on='CODIGO_IES')
    df = df.join(df3.set_index('CODIGO_IES'), on='CODIGO_IES')
    df = df.join(df4.set_index(['CODIGO_IES','CODIGO_CURSO']), on=['CODIGO_IES','CODIGO_CURSO'])
    df = df.join(df5.set_index(['CODIGO_IES','CODIGO_CURSO']), on=['CODIGO_IES','CODIGO_CURSO'])

    return df

def analyzer(df):
    profile = pr(df, title = 'df', minimal = True, html = {'style':{'full_width':True}})
    profile.to_file('df.html')

yappi.set_clock_type("cpu")
yappi.start()

df1, df2, df3, df4, df5 = reader()
df = joiner(df1, df2, df3, df4, df5)
analyzer(df)

yappi.stop()
# yappi.get_func_stats().print_all()
yappi.get_thread_stats().print_all()