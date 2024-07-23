import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status, translations }) {
  const { data, setData, post, processing, errors } = useForm({
    email: '',
  });

  const submit = (e) => {
    e.preventDefault();

    post(route('password.email'));
  };

  return (
    <GuestLayout>
      <Head title="Forgot Password" />

      <div className="mb-4 text-sm text-gray-600">
        {translations.forgot_password_text}
      </div>

      {status && (
        <div className="mb-4 font-medium text-sm text-green-600">{status}</div>
      )}

      <form onSubmit={submit}>
        <TextInput
          id="email"
          type="email"
          name="email"
          value={data.email}
          className="mt-2 block w-full max-w-md mx-auto"
          isFocused={true}
          onChange={(e) => setData('email', e.target.value)}
        />

        <InputError message={errors.email} className="mt-2" />

        <div className="flex flex-col items-center mt-4">
          <PrimaryButton className="ms-4 mt-5" disabled={processing}>
            {translations.send_password_reset_link}
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
