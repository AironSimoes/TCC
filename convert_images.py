#!/usr/bin/env python3
"""
convert_images.py

Gera versões WebP em múltiplas larguras para imagens na pasta `imagens/`.

Requisitos: Python 3 + Pillow (pip install pillow).
Observação: libwebp deve estar disponível no sistema para salvar WebP via Pillow.

Uso:
    python convert_images.py

Os arquivos gerados terão o sufixo -{width}.webp no mesmo diretório.
Ex: imagem-invest-480.webp, imagem-invest-768.webp, imagem-invest-1200.webp
"""
import os
from PIL import Image

SIZES = [480, 768, 1200]
INPUT_DIR = os.path.join(os.path.dirname(__file__), 'imagens')
ALLOWED = ('.jpg', '.jpeg', '.png')


def make_name(path, width):
    base = os.path.splitext(os.path.basename(path))[0]
    safe = base.replace(' ', '-').lower()
    return f"{safe}-{width}.webp"


def convert_image(path):
    try:
        img = Image.open(path)
    except Exception as e:
        print(f"Ignorado (erro ao abrir): {path} -> {e}")
        return

    orig_w, orig_h = img.size
    for w in SIZES:
        if w >= orig_w:
            # também gerar a versão no tamanho original como webp
            out_name = os.path.join(INPUT_DIR, os.path.splitext(os.path.basename(path))[0].replace(' ', '-').lower() + '.webp')
            if os.path.exists(out_name):
                continue
            try:
                img.save(out_name, 'WEBP', quality=80, method=6)
                print(f"Gerado: {out_name} (orig)")
            except Exception as e:
                print(f"Falha ao salvar {out_name}: {e}")
            break

        ratio = w / orig_w
        h = int(orig_h * ratio)
        resized = img.resize((w, h), Image.LANCZOS)
        out_name = os.path.join(INPUT_DIR, make_name(path, w))
        try:
            resized.save(out_name, 'WEBP', quality=80, method=6)
            print(f"Gerado: {out_name}")
        except Exception as e:
            print(f"Falha ao salvar {out_name}: {e}")


def main():
    if not os.path.isdir(INPUT_DIR):
        print(f"Pasta não encontrada: {INPUT_DIR}")
        return

    files = [f for f in os.listdir(INPUT_DIR) if f.lower().endswith(ALLOWED)]
    if not files:
        print("Nenhuma imagem encontrada para conversão em 'imagens/'.")
        return

    print(f"Convertendo {len(files)} arquivo(s) em '{INPUT_DIR}'...")
    for f in files:
        path = os.path.join(INPUT_DIR, f)
        convert_image(path)

    print("Concluído.")


if __name__ == '__main__':
    main()
