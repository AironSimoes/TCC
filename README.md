# Teste de Responsividade — IronInvest

Resumo
- Instruções rápidas para verificar comportamento responsivo do projeto e checklist de verificação.

Como abrir localmente
1. Abra um terminal na pasta do projeto (`index.html` está na raiz).
2. Inicie um servidor simples (recomendado):

```bash
python -m http.server 8000
```

Abra no navegador: http://localhost:8000

Passos de verificação (manual)
- Abra as Ferramentas de Desenvolvedor (F12) → ícone de dispositivo (Toggle device toolbar) e teste nos seguintes breakpoints: 480px, 768px, 1024px.
- Verifique o cabeçalho fixo: o logo, o botão hambúrguer e as ações devem permanecer acessíveis e não sobrepor o conteúdo.
- Teste o menu móvel: clique no botão hambúrguer e confirme que o menu aparece/fecha (ver `aria-expanded`).
- Imagens: confirme que `imagem-invest.jpeg` escala proporcionalmente e não causa overflow.
- Botões: `Abrir conta` e `Simular Investimentos` devem ser facilmente acionáveis em touch (tamanho e espaçamento).
- Fontes: a família `Inter` deve carregar; verifique ausência de flash de layout (FOIT/FOUT) rápido.
- Performance: execute Lighthouse (Desktop e Mobile) para checar pontuações de Performance/Accessibility/Best Practices.

Checklist (marcar manualmente)
- [ ] Header fixo sem sobreposição no conteúdo
- [ ] Menu móvel abre/fecha corretamente (teclado e toque)
- [ ] Imagens responsivas com `max-width:100%` e `height:auto`
- [ ] Textos legíveis em 320–1440px
- [ ] Botões com targets táteis adequados (>44px)
- [ ] Fontes carregam com `preconnect` e `display=swap`
- [ ] Lighthouse: Performance >= 80 (desktop), Accessibility >= 90

Sugestões adicionais
- Otimizar imagens (WebP e diferentes tamanhos + srcset) para melhorar LCP e transferência.
- Incluir atributos `rel="preload"` para fontes críticas caso perceba atraso no carregamento.
- Considerar lazy-loading condicional para imagens acima da dobra apenas quando necessário.

Se quiser, eu posso:
- Gerar versões otimizadas das imagens (WebP + srcset).
- Executar um checklist automatizado com Lighthouse (se você autorizar execução localmente).

Arquivo(s) alterado(s)
- [index.html](index.html)
- [style.css](style.css)

---
Arquivo gerado automaticamente para auxiliar nos testes de responsividade.
