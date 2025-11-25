import 'dart:math';

void main() {
  int longitud = 6020;
  const caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  Random random = Random();
  String contra = '';

  for (int i = 0; i < longitud; i++) {
    int index = random.nextInt(caracteres.length);
    contra += caracteres[index];
  }

  print('La contra es: $contra');
}
